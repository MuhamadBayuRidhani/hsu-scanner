<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_scan_blocks_non_hsu_domain(): void
    {
        $response = $this->post('/scan', [
            'url' => 'https://google.com'
        ]);

        $response->assertSessionHas('error');
    }

    public function test_scan_blocks_spoofed_hsu_domain(): void
    {
        $response = $this->post('/scan', [
            'url' => 'https://fakehsu.go.id'
        ]);

        $response->assertSessionHas('error');
    }

    public function test_whitelist_allows_hsu_and_vertical_agencies(): void
    {
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('web.hsu.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('diskominfo.hsu.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('kab-hulusungaiutara.kpu.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('www.pa-amuntai.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('pa-amuntai.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('www.pn-amuntai.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('hulusungaiutara.kalsel.polri.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('hulusungaiutara.bawaslu.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('hulusungaiutarakab.bps.go.id'));
        $this->assertTrue(\App\Http\Controllers\ScannerController::isHostWhitelisted('hsu.bps.go.id'));

        // Harus tolak domain luar yang bukan bagian dari HSU
        $this->assertFalse(\App\Http\Controllers\ScannerController::isHostWhitelisted('google.com'));
        $this->assertFalse(\App\Http\Controllers\ScannerController::isHostWhitelisted('kalsel.polri.go.id'));
        $this->assertFalse(\App\Http\Controllers\ScannerController::isHostWhitelisted('kpu.go.id'));
        $this->assertFalse(\App\Http\Controllers\ScannerController::isHostWhitelisted('pa-banjarmasin.go.id'));
        $this->assertFalse(\App\Http\Controllers\ScannerController::isHostWhitelisted('fakehsu.go.id'));
    }

    public function test_reports_page_returns_successful_response(): void
    {
        $response = $this->get('/reports');
        $response->assertStatus(200);
        $response->assertSee('Laporan Rekapitulasi');
    }

    public function test_reports_print_page_returns_successful_response(): void
    {
        $response = $this->get('/reports/print');
        $response->assertStatus(200);
        $response->assertSee('PEMERINTAH KABUPATEN HULU SUNGAI UTARA');
    }
}
