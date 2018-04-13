<?php

if (! function_exists('subscription')) {
    /**
     * return the active cookie
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function subscription($key = null)
    {
        return array_get(array_get(\Cookie::get('subscription', null), 'subscription', null), $key, null);
    }
}