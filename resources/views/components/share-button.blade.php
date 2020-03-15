<div>
    <a class="border-0 bg-gray-100 inline-block border-gray-400 border hover:bg-blue-200"
       href="{{ $href }}"
       target="_blank">
        <svg class="h-8 w-8 fill-current inline-block m-2"
             aria-hidden="true"
             focusable="false"
             data-prefix="fab"
             class="text-blue-900"
             role="img"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="{{ $viewBox ?? '0 0 512 512'  }}">
            <path d="{{ $svgPath }}"></path>
        </svg>
    </a>
</div>
