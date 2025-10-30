<x-admin.layout>
    <x-slot name="title">أدوات الصيانة</x-slot>

    <div class="max-w-4xl mx-auto">
        <x-admin.flash />

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">معلومات النظام</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded">
                    <div class="text-sm text-gray-600">حجم الكاش</div>
                    <div class="text-2xl font-bold">{{ $cache_size }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded">
                    <div class="text-sm text-gray-600">حجم ملفات اللوج</div>
                    <div class="text-2xl font-bold">{{ $logs_size }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">إدارة الكاش</h2>
            <p class="text-gray-600 mb-4">
                مسح الكاش يساعد في حل المشاكل وتطبيق التغييرات الجديدة
            </p>
            <form method="POST" action="{{ route('admin.maintenance.clear-cache') }}" class="inline">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    مسح الكاش
                </button>
            </form>
            <form method="POST" action="{{ route('admin.maintenance.optimize') }}" class="inline ml-2">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    تحسين الأداء
                </button>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">إدارة اللوجات</h2>
            <p class="text-gray-600 mb-4">
                مسح ملفات اللوج القديمة لتوفير مساحة التخزين
            </p>
            <form method="POST" action="{{ route('admin.maintenance.clear-logs') }}"
                  onsubmit="return confirm('هل أنت متأكد من حذف جميع ملفات اللوج؟')">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    مسح ملفات اللوج
                </button>
            </form>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>تحذير:</strong> استخدم هذه الأدوات بحذر. مسح الكاش قد يؤثر مؤقتاً على أداء الموقع.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
