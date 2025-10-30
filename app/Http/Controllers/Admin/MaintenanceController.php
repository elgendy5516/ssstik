<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class MaintenanceController extends Controller
{
    /**
     * Show maintenance tools page
     */
    public function index()
    {
        return view('admin.maintenance', [
            'cache_size' => $this->getCacheSize(),
            'logs_size' => $this->getLogsSize(),
        ]);
    }

    /**
     * Clear application cache
     */
    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return back()->with('success', 'تم مسح الكاش بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application
     */
    public function optimize(Request $request)
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return back()->with('success', 'تم تحسين التطبيق بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Clear logs
     */
    public function clearLogs(Request $request)
    {
        try {
            $logPath = storage_path('logs');
            $files = File::glob($logPath . '/*.log');

            foreach ($files as $file) {
                if (File::exists($file)) {
                    File::delete($file);
                }
            }

            return back()->with('success', 'تم مسح ملفات اللوج بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Get cache size
     */
    private function getCacheSize()
    {
        $cachePath = storage_path('framework/cache');
        return $this->getDirectorySize($cachePath);
    }

    /**
     * Get logs size
     */
    private function getLogsSize()
    {
        $logsPath = storage_path('logs');
        return $this->getDirectorySize($logsPath);
    }

    /**
     * Calculate directory size
     */
    private function getDirectorySize($path)
    {
        if (!File::exists($path)) {
            return '0 B';
        }

        $size = 0;
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $size += $file->getSize();
        }

        return $this->formatBytes($size);
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
