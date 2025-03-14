<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    // Menampilkan halaman rekap laporan peminjaman
    public function laporanPeminjaman()
    {
       
        $peminjaman = Pengajuan::with(['user', 'barang'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Habis Pakai');
        })->orderBy('created_at', 'desc')
        ->get();
        return view('admin.laporan.peminjaman', compact('peminjaman'));
    }

    public function laporanPeminjamanall()
    {
       
        $peminjaman = Pengembalian::with(['user', 'barang', 'pengajuan'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Tidak Habis Pakai');
        })->orderBy('created_at', 'desc')->get();
        $pengajuan = Pengajuan::with(['user', 'barang'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Tidak Habis Pakai');
        })->orderBy('created_at', 'desc')->get();
        return view('admin.laporan.peminjamanall', compact('peminjaman','pengajuan'));
    }

    // Menampilkan halaman rekap laporan pengembalian
    public function laporanPengembalian()
    {
        $pengembalian = Pengembalian::with('user', 'barang')->get();
        return view('admin.laporan.pengembalian', compact('pengembalian'));
    }

    // Fungsi untuk mencetak laporan peminjaman
    public function cetakLaporanPeminjaman()
    {
        $peminjaman = Pengajuan::with(['user', 'barang'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Habis Pakai');
        })->orderBy('created_at', 'desc')
        ->get();
        return view('admin.laporan.cetak-peminjaman', compact('peminjaman'));
    }

    // Fungsi untuk mencetak laporan pengembalian
    public function cetakLaporanPengembalian()
    {
        $pengembalian = Pengembalian::with('user', 'barang')->get();
        return view('admin.laporan.cetak-pengembalian', compact('pengembalian'));
    }

    // Cetak laporan peminjaman dalam format PDF
    public function cetakLaporanPeminjamanPDF()
    {
        $peminjaman = Pengajuan::with(['user', 'barang'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Habis Pakai');
        })->orderBy('created_at', 'desc')
        ->get();
        $pdf = PDF::loadView('admin.laporan.cetak-peminjaman', compact('peminjaman'));
        return $pdf->stream('laporan-peminjaman.pdf');
    }

    public function cetakLaporanPeminjamanallPDF()
    {
        $peminjaman = Pengembalian::with(['user', 'barang', 'pengajuan'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Tidak Habis Pakai');
        })->orderBy('created_at', 'desc')->get();
        $pengajuan = Pengajuan::with(['user', 'barang'])->whereHas('barang', function ($query) {
            $query->where('kategori', 'Tidak Habis Pakai');
        })->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('admin.laporan.cetak-peminjamanall', compact('peminjaman','pengajuan'));
        return $pdf->stream('laporan-peminjamanall.pdf');
    }

    // Cetak laporan pengembalian dalam format PDF
    public function cetakLaporanPengembalianPDF()
    {
        $pengembalian = Pengembalian::with('user', 'barang')->get();
        $pdf = PDF::loadView('admin.laporan.cetak-pengembalian', compact('pengembalian'));
        return $pdf->stream('laporan-pengembalian.pdf');
    }
}
