@extends('back.empty')

@section('title', 'إضافة إعدادات جديدة')

@section('style')

@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create New Settings
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>يوجد أخطاء:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- اسم الموقع -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-building text-dark me-1"></i>
                                Title Website
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="أدخل اسم الموقع"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- رقم الهاتف -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone text-dark me-1"></i>
                                Number Phone
                            </label>
                            <input type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="Write your number"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope text-dark me-1"></i>
                                Email
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="ahmed@gmail.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الشعار -->
                        <div class="mb-4">
                            <label for="logo" class="form-label fw-bold">
                                <i class="fas fa-image text-dark me-1"></i>
                                Logo Website
                            </label>
                            <input type="file"
                                   class="form-control @error('logo') is-invalid @enderror"
                                   id="logo"
                                   name="logo"
                                   accept="image/*">
                            <small class="form-text text-muted">
                                اختر صورة للشعار (اختياري)
                            </small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- عن الموقع -->
                        <div class="mb-4">
                            <label for="about" class="form-label fw-bold">
                                <i class="fas fa-info-circle text-dark me-1"></i>
                                About Website
                            </label>
                            <textarea class="form-control @error('about') is-invalid @enderror"
                                      id="about"
                                      name="about"
                                      rows="6"
                                      placeholder="اكتب معلومات عن الموقع..."
                                      required>{{ old('about') }}</textarea>
                            @error('about')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الأزرار -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('settings.show') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save me-1"></i>
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // معاينة الصورة قبل الرفع
    document.getElementById('logo').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'img-thumbnail mt-2';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';

                const preview = document.getElementById('logo-preview');
                if (preview) {
                    preview.remove();
                }

                const container = document.createElement('div');
                container.id = 'logo-preview';
                container.className = 'mt-2';
                container.innerHTML = '<p class="text-muted small mb-2">معاينة الشعار:</p>';
                container.appendChild(img);

                e.target.parentElement.appendChild(container);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
