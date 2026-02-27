<div style="width: 1200px; height: 630px; background: linear-gradient(145deg, #ffffff 0%, #fafaf9 50%, #f5f5f4 100%); position: relative; overflow: hidden;">
    {{-- Black border --}}
    <div style="position: absolute; inset: 0; border: 6px solid #000;"></div>

    {{-- Top gradient bar - Laravel red --}}
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 20px; background: linear-gradient(90deg, #f87171 0%, #b91c1c 100%);"></div>

    {{-- Avatar --}}
    <div style="position: absolute; top: 155px; right: 100px; width: 320px; height: 320px; border-radius: 160px; overflow: hidden; border: 5px solid #000;">
        <img src="{{ asset('images/avatar-boxed.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;" />
    </div>

    {{-- Content --}}
    <div style="position: absolute; top: 88px; left: 104px; width: 640px;">
        <p style="font-size: 36px; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 32px;">FREEK.DEV</p>
        <p style="font-size: 60px; font-weight: 800; color: #000; line-height: 1.08; letter-spacing: -0.02em;">{{ $campaign->name }}</p>
    </div>

    {{-- Tags at bottom --}}
    <p style="position: absolute; bottom: 80px; left: 104px; font-size: 28px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.1em;">
        LARAVEL / PHP / AI
    </p>
</div>
