@php
    /** @var \Juaniquillo\SvgBackendComponents\SvgBackendComponent $component */
    $attributes = new \Illuminate\View\ComponentAttributeBag($component->getAttributeBag()->getAttributes());
    $slot = $component->processContent();
    $settings = $component->getSettings();
@endphp
@include($component->getViewPath(), ['attributes' => $attributes, 'slot' => $slot, 'settings' => $settings])
