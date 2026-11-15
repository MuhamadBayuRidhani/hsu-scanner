import sys
import json
import warnings
import re
import ssl
import socket

# Abaikan warning urllib3 saat melakukan fallback ke verify=False setelah pencatatan status SSL
warnings.filterwarnings('ignore')

import os

# Pastikan SystemRoot terdefinisi agar modul soket/DNS Windows dapat berfungsi
if sys.platform == 'win32':
    if 'SystemRoot' not in os.environ:
        os.environ['SystemRoot'] = os.environ.get('SYSTEMROOT', r'C:\Windows')
    if 'SYSTEMROOT' not in os.environ:
        os.environ['SYSTEMROOT'] = os.environ.get('SystemRoot', r'C:\Windows')
    if 'windir' not in os.environ:
        os.environ['windir'] = os.environ.get('SystemRoot', r'C:\Windows')

import requests
from urllib.parse import urlparse, urlencode, parse_qs, urlunparse


WHITELIST_ROOTS = [
    'hsu.go.id',
    'kab-hulusungaiutara.kpu.go.id',
    'pa-amuntai.go.id',
    'pn-amuntai.go.id',
    'hulusungaiutara.kalsel.polri.go.id',
    'hulusungaiutara.bawaslu.go.id',
    'hulusungaiutarakab.bps.go.id',
    'hsu.bps.go.id',
]


def is_allowed_domain(hostname):
    hostname = (hostname or '').lower().strip()
    if ':' in hostname:
        hostname = hostname.split(':')[0]
    for root in WHITELIST_ROOTS:
        if hostname == root or hostname.endswith('.' + root):
            return True
    return False


def run_scan(url):
    url = url.strip()
    if not url.startswith(('http://', 'https://')):
        url = 'https://' + url

    # Validasi Kunci Domain HSU & Whitelist Instansi Vertikal
    try:
        parsed_url = urlparse(url)
        hostname = (parsed_url.hostname or '').lower()
        if not is_allowed_domain(hostname):
            return {
                "score": 0,
                "error": "Akses Ditolak: Target bukan website resmi Pemerintah Kabupaten Hulu Sungai Utara (*.hsu.go.id) atau instansi vertikal HSU yang terdaftar dalam whitelist.",
                "failed": [],
                "passed": []
            }
    except Exception as e:
        return {
            "score": 0,
            "error": f"Format URL tidak valid: {str(e)}",
            "failed": [],
            "passed": []
        }

    score = 100
    failed_filters = []
    passed_filters = []

    req_headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/115.0.0.0 Safari/537.36'
    }

    # =========================================================================
    # TAHAP 1: Validasi SSL/TLS, Versi Protokol, Redirect HTTP->HTTPS & Koneksi
    # =========================================================================
    ssl_valid = False
    tls_version = None
    ssl_issue_detail = ""
    https_port = parsed_url.port if (parsed_url.scheme == 'https' and parsed_url.port) else 443

    # 1A. Cek langsung sertifikat SSL/TLS & versi protokol TLS menggunakan modul ssl
    try:
        ctx = ssl.create_default_context()
        with socket.create_connection((hostname, https_port), timeout=6) as sock:
            with ctx.wrap_socket(sock, server_hostname=hostname) as ssock:
                tls_version = ssock.version()
                ssl_valid = True
    except ssl.SSLCertVerificationError as cert_err:
        ssl_valid = False
        reason = getattr(cert_err, 'verify_message', None) or str(cert_err)
        ssl_issue_detail = f"Sertifikat SSL tidak valid atau self-signed/expired ({reason})."
        try:
            unverified_ctx = ssl._create_unverified_context()
            with socket.create_connection((hostname, https_port), timeout=5) as sock:
                with unverified_ctx.wrap_socket(sock, server_hostname=hostname) as ssock:
                    tls_version = ssock.version()
        except Exception:
            pass
    except ssl.SSLError as ssl_err:
        ssl_valid = False
        ssl_issue_detail = f"Kegagalan handshake SSL/TLS ({str(ssl_err)})."
    except Exception:
        ssl_valid = False
        ssl_issue_detail = "Port HTTPS (443) tidak merespon atau server belum mendukung SSL/TLS."

    # 1B. Ambil response utama: coba verify=True terlebih dahulu sebelum fallback ke verify=False
    headers = {}
    body = ''
    response = None
    try:
        response = requests.get(url, headers=req_headers, timeout=12, verify=True, allow_redirects=True)
        headers = {k.lower(): v for k, v in response.headers.items()}
        body = response.text
        if response.url.lower().startswith('https://'):
            ssl_valid = True
    except requests.exceptions.SSLError as req_ssl_err:
        ssl_valid = False
        if not ssl_issue_detail:
            ssl_issue_detail = "Sertifikat SSL/TLS gagal diverifikasi oleh Certificate Authority (CA)."
        # Tetap lanjutkan pemindaian menggunakan verify=False setelah status SSL dicatat
        try:
            response = requests.get(url, headers=req_headers, timeout=12, verify=False, allow_redirects=True)
            headers = {k.lower(): v for k, v in response.headers.items()}
            body = response.text
        except Exception:
            if url.startswith('https://'):
                try:
                    url_http = 'http://' + url[8:]
                    response = requests.get(url_http, headers=req_headers, timeout=12, verify=False, allow_redirects=True)
                    headers = {k.lower(): v for k, v in response.headers.items()}
                    body = response.text
                    url = url_http
                except Exception:
                    return {"score": 0, "error": "Gagal Scan: Kendala sertifikat SSL dan koneksi HTTP gagal.", "failed": [], "passed": []}
            else:
                return {"score": 0, "error": "Gagal Scan: Masalah sertifikat SSL pada domain target.", "failed": [], "passed": []}
    except requests.exceptions.ConnectionError as e:
        error_msg = str(e)
        if "getaddrinfo failed" in error_msg or "Name or service not known" in error_msg:
            return {
                "score": 0,
                "error": "Domain tidak ditemukan (DNS Error). Pastikan URL/domain benar dan koneksi internet stabil.",
                "failed": [],
                "passed": []
            }
        # Coba fallback ke HTTP jika HTTPS pada port 443 ditolak tetapi port 80 aktif
        if url.startswith('https://'):
            try:
                url_http = 'http://' + url[8:]
                response = requests.get(url_http, headers=req_headers, timeout=12, verify=False, allow_redirects=True)
                headers = {k.lower(): v for k, v in response.headers.items()}
                body = response.text
                url = url_http
                ssl_valid = False
                ssl_issue_detail = "Server hanya melayani protokol HTTP tanpa enkripsi SSL/TLS."
            except Exception:
                return {
                    "score": 0,
                    "error": "Gagal Scan: Server target tidak merespon atau koneksi ditolak.",
                    "failed": [],
                    "passed": []
                }
        else:
            return {
                "score": 0,
                "error": "Gagal Scan: Server target tidak merespon atau koneksi ditolak.",
                "failed": [],
                "passed": []
            }
    except requests.exceptions.Timeout:
        return {
            "score": 0,
            "error": "Gagal Scan: Batas waktu koneksi habis (Timeout). Server target lambat merespon.",
            "failed": [],
            "passed": []
        }
    except Exception as e:
        return {"score": 0, "error": f"Gagal Scan: {str(e)}", "failed": [], "passed": []}

    # Evaluasi hasil pemeriksaan Validitas SSL/TLS & Versi Protokol
    weak_tls_versions = ('SSLv2', 'SSLv3', 'TLSv1', 'TLSv1.0', 'TLSv1.1')
    if not ssl_valid:
        score -= 10
        proto_info = f" (Protokol terdeteksi: {tls_version})" if tls_version else ""
        failed_filters.append({
            "name": "SSL/TLS Certificate Invalid",
            "desc": f"{ssl_issue_detail or 'Sertifikat SSL/TLS tidak valid, kedaluwarsa, atau self-signed.'}{proto_info}",
            "minus": "-10",
            "category": "ssl_tls"
        })
    elif tls_version in weak_tls_versions:
        score -= 8
        failed_filters.append({
            "name": "Deprecated TLS Protocol",
            "desc": f"Server masih menggunakan versi protokol enkripsi usang ({tls_version}). Wajib minimal TLSv1.2 atau TLSv1.3.",
            "minus": "-8",
            "category": "ssl_tls"
        })
    else:
        passed_filters.append({
            "name": f"SSL/TLS Valid ({tls_version or 'TLSv1.2+'})",
            "category": "ssl_tls"
        })

    # 1C. Cek Redirect HTTP (Port 80) ke HTTPS secara otomatis
    http_probe_url = f"http://{hostname}/"
    redirects_to_https = False
    try:
        http_res = requests.get(http_probe_url, headers=req_headers, timeout=6, verify=False, allow_redirects=True)
        if http_res.url.lower().startswith('https://'):
            redirects_to_https = True
        else:
            for hist in http_res.history:
                loc = hist.headers.get('Location', '') or hist.headers.get('location', '')
                if loc.lower().startswith('https://'):
                    redirects_to_https = True
                    break
    except Exception:
        # Jika port 80 ditutup dan situs hanya menerima HTTPS yang sudah valid
        if ssl_valid and url.lower().startswith('https://'):
            redirects_to_https = True

    if not redirects_to_https:
        score -= 5
        failed_filters.append({
            "name": "HTTP to HTTPS Redirect Missing",
            "desc": "Akses melalui protokol HTTP biasa (port 80) tidak dialihkan secara otomatis ke koneksi aman HTTPS.",
            "minus": "-5",
            "category": "ssl_tls"
        })
    else:
        passed_filters.append({
            "name": "HTTP to HTTPS Redirect",
            "category": "ssl_tls"
        })

    base_url = url if url.endswith('/') else url + '/'

    # =========================================================================
    # TAHAP 2: Analisa Keamanan Header (6 Filter: CSP, HSTS, XFO, XCTO, Referrer, Permissions)
    # =========================================================================
    if 'content-security-policy' not in headers:
        score -= 10
        failed_filters.append({
            "name": "Content-Security-Policy",
            "desc": "Header CSP tidak ditemukan. Rentan terhadap serangan Cross-Site Scripting (XSS).",
            "minus": "-10",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "Content-Security-Policy", "category": "header_security"})

    if 'strict-transport-security' not in headers:
        score -= 8
        failed_filters.append({
            "name": "Strict-Transport-Security",
            "desc": "Header HSTS tidak ditemukan. Koneksi HTTPS tidak dikunci oleh browser.",
            "minus": "-8",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "Strict-Transport-Security", "category": "header_security"})

    if 'x-frame-options' not in headers:
        score -= 7
        failed_filters.append({
            "name": "X-Frame-Options",
            "desc": "Header X-Frame-Options tidak ditemukan. Rentan dibajak via iFrame (Clickjacking).",
            "minus": "-7",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "X-Frame-Options", "category": "header_security"})

    if 'x-content-type-options' not in headers:
        score -= 5
        failed_filters.append({
            "name": "X-Content-Type-Options",
            "desc": "Header X-Content-Type-Options tidak ditemukan. Rentan MIME sniffing vulnerability.",
            "minus": "-5",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "X-Content-Type-Options", "category": "header_security"})

    if 'referrer-policy' not in headers:
        score -= 3
        failed_filters.append({
            "name": "Referrer-Policy",
            "desc": "Header Referrer-Policy tidak ditemukan. URL dan parameter sensitif berisiko bocor melalui header Referer ke situs eksternal.",
            "minus": "-3",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "Referrer-Policy", "category": "header_security"})

    if 'permissions-policy' not in headers and 'feature-policy' not in headers:
        score -= 2
        failed_filters.append({
            "name": "Permissions-Policy",
            "desc": "Header Permissions-Policy tidak ditemukan. Hak akses fitur API browser (kamera, mikrofon, geolokasi) belum dibatasi.",
            "minus": "-2",
            "category": "header_security"
        })
    else:
        passed_filters.append({"name": "Permissions-Policy", "category": "header_security"})

    # =========================================================================
    # TAHAP 2B: Audit Flag Keamanan Cookie (Secure, HttpOnly, SameSite)
    # =========================================================================
    raw_cookies = []
    if response is not None:
        all_res = list(getattr(response, 'history', [])) + [response]
        for r_item in all_res:
            found_in_raw = False
            if hasattr(r_item, 'raw') and hasattr(r_item.raw, 'headers'):
                raw_hdr = r_item.raw.headers
                if hasattr(raw_hdr, 'getlist'):
                    c_list = raw_hdr.getlist('Set-Cookie')
                    if c_list:
                        raw_cookies.extend(c_list)
                        found_in_raw = True
                elif hasattr(raw_hdr, 'get_all'):
                    c_list = raw_hdr.get_all('Set-Cookie')
                    if c_list:
                        raw_cookies.extend(c_list)
                        found_in_raw = True
            if not found_in_raw and 'set-cookie' in r_item.headers:
                raw_cookies.append(r_item.headers['set-cookie'])

    insecure_cookies = []
    seen_cookie_names = set()
    for cookie_str in raw_cookies:
        parts = [p.strip() for p in cookie_str.split(';') if p.strip()]
        if not parts:
            continue
        cookie_name = parts[0].split('=', 1)[0].strip()
        if cookie_name.lower() in seen_cookie_names:
            continue
        seen_cookie_names.add(cookie_name.lower())

        attrs_lower = [p.lower() for p in parts[1:]]
        missing_flags = []
        if not any(a == 'secure' for a in attrs_lower):
            missing_flags.append('Secure')
        if not any(a == 'httponly' for a in attrs_lower):
            missing_flags.append('HttpOnly')
        if not any(a.startswith('samesite=') for a in attrs_lower):
            missing_flags.append('SameSite')

        if missing_flags:
            insecure_cookies.append(f"{cookie_name} (tanpa {', '.join(missing_flags)})")

    if insecure_cookies:
        score -= 5
        failed_filters.append({
            "name": "Insecure Cookie Flags",
            "desc": f"Cookie dibuat oleh server tanpa atribut proteksi lengkap: {'; '.join(insecure_cookies[:3])}.",
            "minus": "-5",
            "category": "cookie_security"
        })
    else:
        passed_filters.append({
            "name": "Cookie Security Flags",
            "category": "cookie_security"
        })

    # =========================================================================
    # TAHAP 3: Analisa File Sensitif Bocor (EXISTING — 1 filter)
    # =========================================================================
    sensitive_files = ['.env', 'backup.zip', '.git/config']
    leaked = []
    for file in sensitive_files:
        try:
            res = requests.get(base_url + file, headers=req_headers, timeout=5, verify=False, allow_redirects=False)
            content_type = res.headers.get('content-type', '').lower()
            if res.status_code == 200 and 'text/html' not in content_type and len(res.content) > 0:
                leaked.append(file)
        except:
            pass

    if leaked:
        score -= 15
        failed_filters.append({
            "name": "Sensitive Data Leak",
            "desc": f"File sensitif bocor ke publik: {', '.join(leaked)}",
            "minus": "-15",
            "category": "sensitive_leak"
        })
    else:
        passed_filters.append({"name": "Sensitive File Protection", "category": "sensitive_leak"})

    # =========================================================================
    # TAHAP 4: File Upload Vulnerability & Web Shell Detection (BARU)
    # =========================================================================
    webshell_paths = [
        'shell.php', 'c99.php', 'r57.php', 'wso.php', 'cmd.php',
        'b374k.php', 'up.php', 'filemanager.php', 'webshell.php',
        'adminer.php', 'shell.asp', 'cmd.asp'
    ]
    detected_shells = []
    for shell in webshell_paths:
        try:
            res = requests.get(base_url + shell, headers=req_headers, timeout=4, verify=False, allow_redirects=False)
            content_type = res.headers.get('content-type', '').lower()
            # Web shell biasanya mengembalikan 200 OK dengan konten non-error
            if res.status_code == 200 and len(res.content) > 50:
                # Pastikan bukan halaman 404 custom yang tetap 200
                body_lower = res.text.lower()
                if 'not found' not in body_lower and '404' not in body_lower:
                    detected_shells.append(shell)
        except:
            pass

    # Cek form upload tanpa validasi tipe file di halaman utama
    has_unvalidated_upload = False
    if '<input' in body.lower() and 'type="file"' in body.lower():
        # Cari pola input file tanpa atribut accept
        file_inputs = re.findall(r'<input[^>]*type=["\']file["\'][^>]*>', body, re.IGNORECASE)
        for fi in file_inputs:
            if 'accept=' not in fi.lower():
                has_unvalidated_upload = True
                break

    if detected_shells:
        score -= 15
        failed_filters.append({
            "name": "Web Shell Detected",
            "desc": f"File web shell terdeteksi accessible: {', '.join(detected_shells)}",
            "minus": "-15",
            "category": "upload_webshell"
        })
    elif has_unvalidated_upload:
        score -= 8
        failed_filters.append({
            "name": "Unvalidated File Upload",
            "desc": "Form upload file ditemukan tanpa validasi tipe file (atribut accept).",
            "minus": "-8",
            "category": "upload_webshell"
        })
    else:
        passed_filters.append({"name": "File Upload & Web Shell Protection", "category": "upload_webshell"})

    # =========================================================================
    # TAHAP 5: SQL Injection (SQLi) & Input Sanitization (BARU)
    # =========================================================================
    sql_error_patterns = [
        r'you have an error in your sql syntax',
        r'warning.*?\bmysqli?\b',
        r'unclosed quotation mark',
        r'microsoft ole db provider',
        r'pg_query\(\)',
        r'pg_exec\(\)',
        r'\bORA-\d{5}\b',
        r'SQLite.*?error',
        r'SQLSTATE\[',
        r'mysql_fetch',
        r'mysql_num_rows',
        r'supplied argument is not a valid MySQL',
        r'Query failed',
        r'SQL syntax.*?MySQL',
        r'valid PostgreSQL result',
        r'Npgsql\.',
        r'unterminated quoted string',
    ]
    sqli_vulnerable = False
    sqli_detail = ""

    # Cek 1: Probe query parameter injection pada URL utama
    parsed = urlparse(response.url)
    params = parse_qs(parsed.query)

    if params:
        # Coba inject setiap parameter yang sudah ada
        for param_name in list(params.keys())[:3]:  # Max 3 parameter
            test_params = dict(params)
            test_params[param_name] = ["' OR '1'='1"]
            test_query = urlencode(test_params, doseq=True)
            test_url = urlunparse(parsed._replace(query=test_query))
            try:
                test_res = requests.get(test_url, headers=req_headers, timeout=5, verify=False, allow_redirects=True)
                for pattern in sql_error_patterns:
                    if re.search(pattern, test_res.text, re.IGNORECASE):
                        sqli_vulnerable = True
                        sqli_detail = f"Parameter '{param_name}' mengembalikan error SQL saat diuji."
                        break
            except:
                pass
            if sqli_vulnerable:
                break

    # Cek 2: Probe halaman umum yang sering memiliki parameter
    if not sqli_vulnerable:
        sqli_test_paths = ['?id=1', '?page=1', '?cat=1', '?search=test']
        for test_path in sqli_test_paths:
            try:
                # Kirim request normal dulu
                normal_url = base_url.rstrip('/') + test_path
                # Lalu kirim dengan payload
                inject_url = normal_url.rsplit('=', 1)[0] + "=' OR '1'='1"
                test_res = requests.get(inject_url, headers=req_headers, timeout=5, verify=False, allow_redirects=True)
                for pattern in sql_error_patterns:
                    if re.search(pattern, test_res.text, re.IGNORECASE):
                        sqli_vulnerable = True
                        sqli_detail = f"Endpoint '{test_path}' mengembalikan error SQL saat diuji dengan payload injeksi."
                        break
            except:
                pass
            if sqli_vulnerable:
                break

    if sqli_vulnerable:
        score -= 15
        failed_filters.append({
            "name": "SQL Injection Vulnerability",
            "desc": f"Potensi kerentanan SQLi terdeteksi. {sqli_detail}",
            "minus": "-15",
            "category": "sqli_sanitization"
        })
    else:
        passed_filters.append({"name": "SQL Injection & Input Sanitization", "category": "sqli_sanitization"})

    # =========================================================================
    # TAHAP 6: Authentication & Brute-Force Protection (BARU)
    # =========================================================================
    has_rate_limit = False
    login_found = False
    login_protected = False

    # Cek rate-limit headers di response utama
    rate_limit_headers = ['x-ratelimit-limit', 'x-ratelimit-remaining', 'x-rate-limit-limit',
                          'retry-after', 'ratelimit-limit', 'ratelimit-remaining']
    for rlh in rate_limit_headers:
        if rlh in headers:
            has_rate_limit = True
            break

    # Probe path login umum
    login_paths = ['/login', '/admin', '/wp-login.php', '/administrator',
                   '/user/login', '/signin', '/auth/login', '/admin/login']
    for lpath in login_paths:
        try:
            login_res = requests.get(base_url.rstrip('/') + lpath, headers=req_headers,
                                     timeout=5, verify=False, allow_redirects=True)
            if login_res.status_code == 200:
                login_body = login_res.text.lower()
                # Cek apakah ini benar-benar halaman login (bukan redirect ke homepage)
                login_indicators = ['password', 'kata sandi', 'login', 'sign in', 'masuk']
                if any(indicator in login_body for indicator in login_indicators):
                    login_found = True
                    login_resp_headers = {k.lower(): v for k, v in login_res.headers.items()}

                    # Cek proteksi pada halaman login
                    captcha_indicators = ['captcha', 'recaptcha', 'hcaptcha', 'turnstile',
                                          'g-recaptcha', 'cf-turnstile', 'h-captcha']
                    has_captcha = any(ci in login_body for ci in captcha_indicators)

                    has_login_rate_limit = any(rlh in login_resp_headers for rlh in rate_limit_headers)

                    # Cek CSRF token (indikasi proteksi)
                    has_csrf = 'csrf' in login_body or '_token' in login_body

                    if has_captcha or has_login_rate_limit:
                        login_protected = True
                    break
        except:
            pass

    if login_found and not login_protected and not has_rate_limit:
        score -= 10
        failed_filters.append({
            "name": "Brute-Force Protection Missing",
            "desc": "Halaman login terdeteksi tanpa CAPTCHA atau rate-limiting. Rentan terhadap serangan brute-force.",
            "minus": "-10",
            "category": "auth_bruteforce"
        })
    elif not has_rate_limit and not login_found:
        # Tidak ada login page dan tidak ada rate-limit headers — beri pass dengan catatan
        passed_filters.append({"name": "Authentication & Brute-Force", "category": "auth_bruteforce"})
    else:
        passed_filters.append({"name": "Authentication & Brute-Force", "category": "auth_bruteforce"})

    # =========================================================================
    # TAHAP 7: File Integrity Monitoring / FIM (BARU)
    # =========================================================================
    fim_paths = [
        'phpinfo.php', 'info.php', 'debug', 'server-status', 'server-info',
        'elmah.axd', 'wp-config.php.bak', '.htaccess', 'web.config',
        'test.php', 'readme.html', 'license.txt', 'CHANGELOG.md'
    ]
    exposed_configs = []
    for fpath in fim_paths:
        try:
            res = requests.get(base_url + fpath, headers=req_headers, timeout=4, verify=False, allow_redirects=False)
            content_type = res.headers.get('content-type', '').lower()
            if res.status_code == 200 and len(res.content) > 50:
                body_check = res.text.lower()
                # Pastikan bukan halaman 404 custom
                if 'not found' not in body_check and '404' not in body_check:
                    # Untuk phpinfo, cek lebih spesifik
                    if fpath in ['phpinfo.php', 'info.php']:
                        if 'php version' in body_check or 'phpinfo()' in body_check or 'configuration' in body_check:
                            exposed_configs.append(fpath)
                    elif fpath == 'server-status':
                        if 'server version' in body_check or 'apache' in body_check:
                            exposed_configs.append(fpath)
                    elif fpath == 'server-info':
                        if 'server version' in body_check or 'module' in body_check:
                            exposed_configs.append(fpath)
                    elif fpath == 'elmah.axd':
                        if 'error log' in body_check or 'elmah' in body_check:
                            exposed_configs.append(fpath)
                    elif fpath in ['.htaccess', 'web.config', 'wp-config.php.bak']:
                        if 'text/html' not in content_type:
                            exposed_configs.append(fpath)
                    elif fpath == 'readme.html':
                        if 'wordpress' in body_check:
                            exposed_configs.append(fpath)
                    else:
                        exposed_configs.append(fpath)
        except:
            pass

    if exposed_configs:
        penalty = min(15, len(exposed_configs) * 5)
        score -= penalty
        failed_filters.append({
            "name": "Debug/Config Files Exposed",
            "desc": f"File konfigurasi/debug terekspos publik: {', '.join(exposed_configs)}",
            "minus": f"-{penalty}",
            "category": "fim"
        })
    else:
        passed_filters.append({"name": "File Integrity Monitoring", "category": "fim"})

    # =========================================================================
    # TAHAP 8: Dependency & Framework Vulnerability (BARU)
    # =========================================================================
    framework_issues = []

    # Cek header X-Powered-By
    x_powered = headers.get('x-powered-by', '')
    if x_powered:
        framework_issues.append(f"X-Powered-By: {x_powered}")

    # Cek header Server — apakah menampilkan versi detail
    server_header = headers.get('server', '')
    if server_header:
        # Jika mengandung versi (angka setelah /)
        if re.search(r'/[\d.]+', server_header):
            framework_issues.append(f"Server: {server_header}")

    # Cek meta generator di HTML body (WordPress, Joomla, Drupal, dll)
    generator_match = re.search(r'<meta[^>]*name=["\']generator["\'][^>]*content=["\']([^"\']+)["\']', body, re.IGNORECASE)
    if not generator_match:
        generator_match = re.search(r'<meta[^>]*content=["\']([^"\']+)["\'][^>]*name=["\']generator["\']', body, re.IGNORECASE)
    if generator_match:
        generator_value = generator_match.group(1).strip()
        framework_issues.append(f"Meta Generator: {generator_value}")

    # Cek WordPress-specific indicators
    if '/wp-content/' in body or '/wp-includes/' in body:
        if not any('WordPress' in fi or 'wp-' in fi for fi in framework_issues):
            framework_issues.append("WordPress CMS terdeteksi dari path wp-content/wp-includes")

    if framework_issues:
        score -= 10
        failed_filters.append({
            "name": "Framework/Version Exposed",
            "desc": f"Informasi framework/versi terekspos: {'; '.join(framework_issues)}",
            "minus": "-10",
            "category": "dependency_framework"
        })
    else:
        passed_filters.append({"name": "Dependency & Framework Security", "category": "dependency_framework"})

    # =========================================================================
    # Return hasil akhir
    # =========================================================================
    return {
        "score": max(0, score),
        "failed": failed_filters,
        "passed": passed_filters,
        "error": None
    }


if __name__ == "__main__":
    if len(sys.argv) > 1:
        print(json.dumps(run_scan(sys.argv[1])))
    else:
        print(json.dumps({"error": "URL tidak dimasukkan.", "score": 0, "failed": [], "passed": []}))