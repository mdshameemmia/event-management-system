<?php

class AlertMessage
{
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';

    public function render($type, $message)
    {
        $alertClasses = [
            self::TYPE_SUCCESS => 'bg-success text-white',
            self::TYPE_INFO => 'bg-info text-white',
            self::TYPE_WARNING => 'bg-warning text-dark',
            self::TYPE_DANGER => 'bg-danger text-white',
        ];

        $alertClass = isset($alertClasses[$type]) ? $alertClasses[$type] : 'bg-secondary text-white';

        return <<<HTML
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header {$alertClass}">
                        <strong class="me-auto">Message</strong> 
                        <small>Now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {$message}
                    </div>
                </div>
            </div>
            <script>
                const toastLiveExample = document.getElementById('liveToast')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
            </script>
HTML;
    }
}
