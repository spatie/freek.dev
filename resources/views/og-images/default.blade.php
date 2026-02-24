<div style="width: 1200px; height: 630px; background: linear-gradient(145deg, #ffffff 0%, #fafaf9 50%, #f5f5f4 100%); position: relative; overflow: hidden;">
    {{-- Black border --}}
    <div style="position: absolute; inset: 0; border: 6px solid #000;"></div>

    {{-- Top gradient bar --}}
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 20px; background: linear-gradient(90deg, #f87171 0%, #b91c1c 100%);"></div>

    {{-- Avatar --}}
    <div style="position: absolute; top: 155px; right: 100px; width: 320px; height: 320px; border-radius: 160px; overflow: hidden; border: 5px solid #000;">
        <img src="{{ asset('images/avatar-boxed.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;" />
    </div>

    {{-- Content --}}
    <div style="position: absolute; top: 170px; left: 104px; width: 580px;">
        <p style="font-size: 80px; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.1em; line-height: 1.1;">FREEK.DEV</p>
        <p style="font-size: 30px; font-weight: 500; color: #525252; margin-top: 24px; line-height: 1.5;">Freek Van der Herten's blog on Laravel, PHP and AI</p>
        <p style="font-size: 24px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 32px;">LARAVEL / PHP / AI</p>
    </div>
</div>
