@extends('welcome.layout')

@section('title', 'Sell Your Car - Cental')

@push('styles')
<style>
/* ── Hero Banner ── */
.sell-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 60%, #1a1a1a 100%);
    padding: 80px 0 60px;
    position: relative;
    overflow: hidden;
}
.sell-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -80px;
    width: 420px; height: 420px;
    background: rgba(220,20,20,0.08);
    border-radius: 50%;
}
.sell-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 10%;
    width: 200px; height: 200px;
    background: rgba(220,20,20,0.05);
    border-radius: 50%;
}
.sell-hero h1 { color: #fff; font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 2.8rem; }
.sell-hero h1 span { color: #dc3545; }
.sell-hero p { color: rgba(255,255,255,0.65); font-size: 1.05rem; }
.breadcrumb-item a { color: #dc3545; }
.breadcrumb-item.active { color: rgba(255,255,255,0.5); }
.breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.3); }

/* ── Steps Bar ── */
.steps-bar { background: #fff; box-shadow: 0 2px 20px rgba(0,0,0,0.07); border-bottom: 3px solid #f5f5f5; }
.step-item { display: flex; align-items: center; gap: 12px; padding: 18px 0; }
.step-num { width: 38px; height: 38px; border-radius: 50%; background: #f0f0f0; color: #999;
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .9rem;
            transition: all .3s; flex-shrink: 0; }
.step-item.active .step-num { background: #dc3545; color: #fff; }
.step-item.done .step-num { background: #198754; color: #fff; }
.step-label { font-size: .82rem; font-weight: 600; color: #999; font-family: 'Montserrat', sans-serif; }
.step-item.active .step-label { color: #dc3545; }
.step-item.done .step-label { color: #198754; }
.step-divider { flex: 1; height: 2px; background: #eee; margin: 0 8px; }
.step-divider.done { background: #198754; }

/* ── Section Cards ── */
.form-section-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    padding: 30px 32px;
    margin-bottom: 24px;
    border: 1px solid #f0f0f0;
}
.section-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #1a1a1a;
    margin-bottom: 22px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f5f5f5;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-title .icon-badge {
    width: 34px; height: 34px; border-radius: 8px;
    background: rgba(220,53,69,0.1);
    display: flex; align-items: center; justify-content: center;
    color: #dc3545; font-size: .9rem;
}

/* ── Form Controls ── */
.form-label { font-size: .82rem; font-weight: 600; color: #555; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; }
.form-control, .form-select {
    border: 1.5px solid #e8e8e8;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: .9rem;
    transition: border-color .25s, box-shadow .25s;
    background: #fdfdfd;
}
.form-control:focus, .form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220,53,69,.1);
    background: #fff;
}
.form-control::placeholder { color: #bbb; }
.input-group-text { background: #f8f8f8; border: 1.5px solid #e8e8e8; color: #777; font-size: .85rem; }

/* ── Image Upload ── */
.upload-zone {
    border: 2px dashed #ddd;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all .3s;
    background: #fafafa;
}
.upload-zone:hover, .upload-zone.dragover {
    border-color: #dc3545;
    background: rgba(220,53,69,.03);
}
.upload-zone .upload-icon { font-size: 2.5rem; color: #ccc; margin-bottom: 12px; }
.upload-zone h6 { color: #444; font-weight: 600; margin-bottom: 4px; }
.upload-zone p { color: #999; font-size: .82rem; margin: 0; }
.img-preview-wrap { position: relative; display: inline-block; margin: 6px; }
.img-preview-wrap img { width: 90px; height: 70px; object-fit: cover; border-radius: 8px; border: 2px solid #eee; }
.img-remove { position: absolute; top: -6px; right: -6px; width: 20px; height: 20px;
              background: #dc3545; color: #fff; border-radius: 50%; border: none;
              font-size: .65rem; display: flex; align-items: center; justify-content: center; cursor: pointer; }

/* ── Price Suggestion ── */
.price-hint { background: linear-gradient(135deg, rgba(220,53,69,.06), rgba(220,53,69,.02));
              border: 1px solid rgba(220,53,69,.15); border-radius: 10px; padding: 14px 16px; margin-top: 10px; }
.price-hint h6 { color: #dc3545; font-size: .8rem; font-weight: 700; margin-bottom: 4px; }
.price-hint p  { color: #666; font-size: .78rem; margin: 0; }

/* ── Condition Toggle ── */
.condition-toggle { display: flex; gap: 12px; }
.condition-btn { flex: 1; padding: 12px; border: 2px solid #e8e8e8; border-radius: 10px;
                 text-align: center; cursor: pointer; transition: all .25s; background: #fff; }
.condition-btn:hover { border-color: #dc3545; }
.condition-btn.selected { border-color: #dc3545; background: rgba(220,53,69,.05); }
.condition-btn .cb-icon { font-size: 1.4rem; display: block; margin-bottom: 4px; }
.condition-btn .cb-label { font-size: .8rem; font-weight: 700; color: #444; }
.condition-btn.selected .cb-label { color: #dc3545; }

/* ── Submit Button ── */
.btn-submit-sell {
    background: #dc3545;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 14px 48px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    letter-spacing: .5px;
    transition: all .3s;
    position: relative;
    overflow: hidden;
}
.btn-submit-sell::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0);
    transition: background .3s;
}
.btn-submit-sell:hover { background: #b02a37; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(220,53,69,.35); color: #fff; }

/* ── Sidebar Info ── */
.info-sidebar .info-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
    overflow: hidden;
    margin-bottom: 20px;
}
.info-card-header {
    background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
    padding: 16px 20px;
    color: #fff;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: .88rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-card-header i { color: #dc3545; }
.info-card-body { padding: 18px 20px; }
.process-step { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; }
.process-step:last-child { margin-bottom: 0; }
.ps-num { width: 28px; height: 28px; border-radius: 50%; background: #dc3545; color: #fff;
          font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ps-text h6 { font-size: .82rem; font-weight: 700; color: #222; margin-bottom: 2px; }
.ps-text p  { font-size: .75rem; color: #888; margin: 0; line-height: 1.4; }
.stat-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
.stat-row:last-child { border: none; }
.stat-label { font-size: .78rem; color: #888; }
.stat-val { font-size: .88rem; font-weight: 700; color: #dc3545; }

/* ── Alert Banner ── */
.success-banner { background: linear-gradient(135deg, #198754, #157347); color: #fff; border-radius: 12px; padding: 18px 22px; display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
.success-banner i { font-size: 1.5rem; opacity: .9; }
</style>
@endpush

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="container mt-3">
    <div class="success-banner wow fadeInDown" data-wow-delay="0.1s">
        <i class="fas fa-check-circle"></i>
        <div>
            <strong>Request Submitted!</strong><br>
            <small>{{ session('success') }}</small>
        </div>
        <button type="button" class="btn-close btn-close-white ms-auto" onclick="this.parentElement.remove()"></button>
    </div>
</div>
@endif

@if($errors->any())
<div class="container mt-3">
    <div class="alert alert-danger rounded-3">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ $errors->first() }}
    </div>
</div>
@endif

{{-- ════ HERO ════ --}}
<div class="sell-hero wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sell Your Car</li>
                    </ol>
                </nav>
                <h1 class="mb-3">Sell Your Car <span>Fast & Easy</span></h1>
                <p class="mb-0">List your vehicle in minutes. Our team reviews every request and connects you with serious buyers.</p>
            </div>
            <div class="col-lg-5 text-end d-none d-lg-block">
                <div style="font-size: 7rem; opacity: .08; color: #dc3545; font-family: 'Montserrat', sans-serif; font-weight: 900; line-height: 1;">SELL</div>
            </div>
        </div>
    </div>
</div>

{{-- ════ STEPS ════ --}}
<div class="steps-bar wow fadeInDown" data-wow-delay="0.15s">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="step-item active">
                <div class="step-num">1</div>
                <div class="step-label">Car Details</div>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-label">Review</div>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-label">Approval</div>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <div class="step-num">4</div>
                <div class="step-label">Listed!</div>
            </div>
        </div>
    </div>
</div>

{{-- ════ FORM + SIDEBAR ════ --}}
<div class="container py-5">
    <div class="row g-4">

        {{-- ── MAIN FORM ── --}}
        <div class="col-lg-8">
            <form action="{{ route('welcome.car-sale-requests.store') }}" method="POST" enctype="multipart/form-data" id="sellForm">
                @csrf

                {{-- 1. Basic Info --}}
                <div class="form-section-card wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-title">
                        <div class="icon-badge"><i class="fas fa-car"></i></div>
                        Basic Information
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                                   value="{{ old('brand') }}" placeholder="e.g. Toyota" required>
                            @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                                   value="{{ old('model') }}" placeholder="e.g. Camry" required>
                            @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Year <span class="text-danger">*</span></label>
                            <select name="year" class="form-select @error('year') is-invalid @enderror" required>
                                <option value="">Select year</option>
                                @for($y = date('Y') + 1; $y >= 1990; $y--)
                                    <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Color</label>
                            <input type="text" name="color" class="form-control"
                                   value="{{ old('color') }}" placeholder="e.g. Pearl White">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Engine Capacity (cc)</label>
                            <input type="number" name="engine_capacity" class="form-control"
                                   value="{{ old('engine_capacity') }}" placeholder="e.g. 2000" min="500" max="10000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Number of Doors</label>
                            <select name="number_doors" class="form-select">
                                @foreach([2,3,4,5] as $d)
                                    <option value="{{ $d }}" {{ old('number_doors','4') == $d ? 'selected':'' }}>{{ $d }} Doors</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 2. Technical Specs --}}
                <div class="form-section-card wow fadeInUp" data-wow-delay="0.15s">
                    <div class="section-title">
                        <div class="icon-badge"><i class="fas fa-cogs"></i></div>
                        Technical Specifications
                    </div>

                    {{-- Condition Toggle --}}
                    <div class="mb-4">
                        <label class="form-label d-block mb-2">Condition <span class="text-danger">*</span></label>
                        <div class="condition-toggle">
                            <div class="condition-btn {{ old('condition','used') == 'used' ? 'selected' : '' }}"
                                 onclick="selectCondition('used', this)">
                                <span class="cb-icon">🚘</span>
                                <div class="cb-label">Used</div>
                            </div>
                            <div class="condition-btn {{ old('condition') == 'new' ? 'selected' : '' }}"
                                 onclick="selectCondition('new', this)">
                                <span class="cb-icon">✨</span>
                                <div class="cb-label">New / Like New</div>
                            </div>
                        </div>
                        <input type="hidden" name="condition" id="conditionInput" value="{{ old('condition','used') }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Transmission <span class="text-danger">*</span></label>
                            <select name="transmission" class="form-select" required>
                                <option value="manual"    {{ old('transmission')=='manual'    ?'selected':'' }}>Manual</option>
                                <option value="automatic" {{ old('transmission')=='automatic' ?'selected':'' }}>Automatic</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fuel Type <span class="text-danger">*</span></label>
                            <select name="fuel_type" class="form-select" required>
                                <option value="petrol"   {{ old('fuel_type')=='petrol'   ?'selected':'' }}>⛽ Petrol</option>
                                <option value="diesel"   {{ old('fuel_type')=='diesel'   ?'selected':'' }}>🛢️ Diesel</option>
                                <option value="electric" {{ old('fuel_type')=='electric' ?'selected':'' }}>⚡ Electric</option>
                                <option value="hybrid"   {{ old('fuel_type')=='hybrid'   ?'selected':'' }}>🔋 Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mileage (km) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="mileage" class="form-control"
                                       value="{{ old('mileage', 0) }}" min="0" required>
                                <span class="input-group-text">km</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Pricing --}}
                <div class="form-section-card wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-title">
                        <div class="icon-badge"><i class="fas fa-tag"></i></div>
                        Asking Price
                    </div>
                    <div class="row g-3 align-items-start">
                        <div class="col-md-6">
                            <label class="form-label">Price (USD) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}" min="0" step="0.01" placeholder="0.00" required>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="price-hint">
                                <h6><i class="fas fa-lightbulb me-1"></i> Pricing Tip</h6>
                                <p>Set a competitive price. Overpriced cars take 3× longer to sell. Check similar listings to benchmark.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Description --}}
                <div class="form-section-card wow fadeInUp" data-wow-delay="0.22s">
                    <div class="section-title">
                        <div class="icon-badge"><i class="fas fa-align-left"></i></div>
                        Description
                    </div>
                    <label class="form-label">Tell buyers about your car <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe condition, service history, any modifications, reason for selling..."
                              id="descField" required>{{ old('description') }}</textarea>
                    <div class="d-flex justify-content-between mt-1">
                        @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
                        <small class="text-muted ms-auto" id="charCount">0 / 1000</small>
                    </div>
                </div>

                {{-- 5. Photos --}}
                <div class="form-section-card wow fadeInUp" data-wow-delay="0.25s">
                    <div class="section-title">
                        <div class="icon-badge"><i class="fas fa-camera"></i></div>
                        Photos <span class="text-muted fw-normal" style="font-size:.75rem;">(up to 8 photos)</span>
                    </div>

                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('imageInput').click()">
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <h6>Drop photos here or click to browse</h6>
                        <p>JPG, PNG, WEBP — max 2MB each. First photo = cover image.</p>
                    </div>
                    <input type="file" name="images[]" id="imageInput" multiple accept="image/*" style="display:none">

                    <div class="mt-3 d-flex flex-wrap" id="previewContainer"></div>
                </div>

                {{-- Submit --}}
                <div class="d-flex align-items-center gap-3 wow fadeInUp" data-wow-delay="0.28s">
                    <button type="submit" class="btn btn-submit-sell">
                        <i class="fas fa-paper-plane me-2"></i> Submit for Review
                    </button>
                    <a href="{{ route('welcome.car-sale-requests.my') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                        My Requests
                    </a>
                </div>

            </form>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="col-lg-4 info-sidebar">

            {{-- How it works --}}
            <div class="info-card wow fadeInRight" data-wow-delay="0.15s">
                <div class="info-card-header">
                    <i class="fas fa-route"></i> How It Works
                </div>
                <div class="info-card-body">
                    <div class="process-step">
                        <div class="ps-num">1</div>
                        <div class="ps-text">
                            <h6>Submit Your Car</h6>
                            <p>Fill in the form with your car's details and photos.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="ps-num">2</div>
                        <div class="ps-text">
                            <h6>Team Review</h6>
                            <p>Our manager reviews your listing within 24 hours.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="ps-num">3</div>
                        <div class="ps-text">
                            <h6>Get Approved</h6>
                            <p>Once approved, your car is listed on our platform.</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="ps-num">4</div>
                        <div class="ps-text">
                            <h6>Sell It!</h6>
                            <p>Buyers contact you directly. We handle the rest.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="info-card wow fadeInRight" data-wow-delay="0.2s">
                <div class="info-card-header">
                    <i class="fas fa-chart-bar"></i> Why Sell With Us
                </div>
                <div class="info-card-body">
                    <div class="stat-row">
                        <span class="stat-label">Avg. time to sell</span>
                        <span class="stat-val">7 Days</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Active buyers</span>
                        <span class="stat-val">8,200+</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Cars sold this month</span>
                        <span class="stat-val">127</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Listing fee</span>
                        <span class="stat-val">Free</span>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="info-card wow fadeInRight" data-wow-delay="0.25s">
                <div class="info-card-header">
                    <i class="fas fa-star"></i> Tips for a Quick Sale
                </div>
                <div class="info-card-body">
                    <ul class="list-unstyled mb-0" style="font-size:.82rem; color:#555; line-height:2;">
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Upload at least 5 clear photos</li>
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Include front, rear, interior shots</li>
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Be honest about condition & mileage</li>
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Set a fair market price</li>
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Mention recent service work</li>
                        <li><i class="fas fa-check-circle text-danger me-2" style="font-size:.7rem;"></i>Respond to inquiries quickly</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Condition toggle
function selectCondition(val, el) {
    document.querySelectorAll('.condition-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('conditionInput').value = val;
}

// ── Char counter
const desc = document.getElementById('descField');
const counter = document.getElementById('charCount');
desc.addEventListener('input', () => {
    counter.textContent = desc.value.length + ' / 1000';
    if (desc.value.length > 950) counter.style.color = '#dc3545';
    else counter.style.color = '';
});

// ── Drag & drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

// ── Image preview
const input = document.getElementById('imageInput');
const preview = document.getElementById('previewContainer');
let allFiles = [];

input.addEventListener('change', () => handleFiles(input.files));

function handleFiles(files) {
    Array.from(files).slice(0, 8 - allFiles.length).forEach(file => {
        allFiles.push(file);
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div');
            wrap.className = 'img-preview-wrap';
            const idx = allFiles.length - 1;
            wrap.innerHTML = `<img src="${e.target.result}" alt="preview">
                <button type="button" class="img-remove" onclick="removeImg(${idx}, this.parentElement)">✕</button>`;
            if (allFiles.length === 1) {
                const badge = document.createElement('div');
                badge.style.cssText = 'position:absolute;bottom:4px;left:4px;background:#dc3545;color:#fff;font-size:.6rem;padding:2px 6px;border-radius:4px;font-weight:700;';
                badge.textContent = 'COVER';
                wrap.appendChild(badge);
            }
            preview.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
    updateFileInput();
}

function removeImg(idx, el) {
    allFiles.splice(idx, 1);
    el.remove();
    updateFileInput();
}

function updateFileInput() {
    const dt = new DataTransfer();
    allFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}
</script>
@endpush
