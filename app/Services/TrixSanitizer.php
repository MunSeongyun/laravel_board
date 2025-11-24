<?php

namespace App\Services;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class TrixSanitizer
{
    protected HtmlSanitizer $sanitizer;

    public function __construct()
    {
        // 생성자에서 설정을 한 번만 로드합니다.
        $config = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('figure', ['class', 'data-trix-attachment', 'data-trix-content-type', 'data-trix-attributes'])
            ->allowElement('figcaption', ['class', 'dir'])
            ->allowElement('div', ['class'])
            ->allowElement('span', ['class', 'data-trix-cursor-target'])
            ->allowElement('img', ['src', 'width', 'height', 'data-trix-mutable'])
            ->allowElement('a', ['href', 'rel', 'target', 'title'])
            ->forceAttribute('a', 'rel', 'noopener noreferrer')
            ->allowAttribute('src', ['img'])
            ->allowAttribute('href', ['a']);

        $this->sanitizer = new HtmlSanitizer($config);
    }

    public function clean(?string $html): string
    {
        if (empty($html)) return '';
        return $this->sanitizer->sanitize($html);
    }
}