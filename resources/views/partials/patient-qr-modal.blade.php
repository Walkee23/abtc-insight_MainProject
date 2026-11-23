{{-- Scan / upload the Patient ID QR code. Used with public/js/patient-qr.js (Returning Patient, Tracking Portal). --}}
<div id="qrScannerModal" role="dialog" aria-modal="true" aria-labelledby="qrModalTitle" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm items-center justify-center p-4">
  <div class="bg-surface-container-lowest rounded-2xl max-w-md w-full p-6 shadow-2xl border border-outline-variant/30 space-y-4 max-h-[92vh] overflow-y-auto">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">qr_code_scanner</span>
        <h3 id="qrModalTitle" class="font-bold text-base text-on-surface">Scan or Upload Patient QR</h3>
      </div>
      <button type="button" id="closeQrModalBtn" aria-label="Close" class="p-1 text-on-surface-variant hover:text-on-surface rounded-lg">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <div class="grid grid-cols-2 gap-2 p-1 bg-surface-container rounded-xl">
      <button type="button" id="tabCameraBtn" class="py-2 px-3 rounded-lg text-xs font-bold bg-white text-primary shadow-sm transition-all flex items-center justify-center gap-1.5">
        <span class="material-symbols-outlined text-[16px]">photo_camera</span>
        Use Camera
      </button>
      <button type="button" id="tabUploadBtn" class="py-2 px-3 rounded-lg text-xs font-bold text-on-surface-variant hover:text-on-surface transition-all flex items-center justify-center gap-1.5">
        <span class="material-symbols-outlined text-[16px]">upload_file</span>
        Upload QR Photo
      </button>
    </div>

    <div id="cameraPanel" class="space-y-3">
      <div id="qrReader" class="w-full rounded-xl overflow-hidden bg-black min-h-[240px]"></div>
      <p class="text-xs text-on-surface-variant text-center">Point your camera at the QR code you received at your last visit.</p>
    </div>

    <div id="uploadPanel" class="hidden space-y-3">
      <input type="file" id="qrFileInput" accept="image/png,image/jpeg,.png,.jpg,.jpeg" class="hidden" />
      <div id="qrFileDropzone" role="button" tabindex="0" class="border-2 border-dashed border-outline-variant/60 hover:border-primary rounded-xl p-8 text-center cursor-pointer transition-colors bg-surface-container-low/50">
        <span class="material-symbols-outlined text-4xl text-primary mb-2">qr_code_2</span>
        <p class="text-sm font-bold text-on-surface">Choose your QR code image</p>
        <p class="text-[11px] text-on-surface-variant mt-1">Only a PNG or JPG photo of your Patient ID QR code (up to 5 MB). Any other kind of file is rejected.</p>
      </div>
      <div id="qrFileReader" class="hidden"></div>
    </div>

    <p id="qrModalError" role="alert" class="hidden text-xs text-error font-semibold text-center bg-error-container/50 py-2 px-3 rounded-lg"></p>
  </div>
</div>
