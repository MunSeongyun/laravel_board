<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <x-rich-text::styles theme="richtextlaravel" data-turbo-track="false" />
        <script type="module">
            import {
                Application,
                Controller
            } from 'https://cdn.skypack.dev/@hotwired/stimulus'

            window.Stimulus = Application.start()

            class UploadManager {
                upload(event) {
                    if (! event?.attachment?.file) return
                    
                    const form = new FormData()
                    form.append('attachment', event.attachment.file)

                    const options = {
                        method: 'POST',
                        body: form,
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                        }
                    }

                    fetch('/attachments', options)
                        .then(resp => resp.json())
                        .then((data) => {
                            event.attachment.setAttributes({
                                url: data.image_url,
                                href: data.image_url,
                            })
                        })
                        .catch(() => {
                            alert('max file size exceeded')
                            event.attachment.remove()
                        })
                }
            }

            Stimulus.register("rich-text-uploader", class extends Controller {
                static values = { acceptFiles: Boolean }

                #uploader

                connect() {
                    this.#uploader = new UploadManager()
                }

                upload(event) {
                    if (! this.acceptFilesValue) {
                        event.preventDefault()
                        return
                    }

                    this.#uploader.upload(event)
                }
            })
        </script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
