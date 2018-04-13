<?php

namespace App\ContentProviders;

interface ContentProviderContract {
    /**
     * Imports content from the given content provider through api calls.
     *
     * @return bool
     */
    public function importContent(): bool;
}
