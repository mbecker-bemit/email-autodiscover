<?php

namespace Bemit\Autodiscover;


class User {

    /**
     * Used e.g. for setting user@domain.tld as username
     *
     * @return string|null
     */
    public function getEmail() {
        if(filter_has_var(INPUT_GET, 'email')) {
            $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);

        } else if(filter_has_var(INPUT_POST, 'email')) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        } else if(filter_has_var(INPUT_GET, 'Email')) {
            // as outlook2016 triggers the JSON with get parameter 'Email'
            $email = filter_input(INPUT_GET, 'Email', FILTER_SANITIZE_EMAIL);

        } else if(filter_has_var(INPUT_SERVER, 'HTTP_X_USER_IDENTITY')) {
            // Office 2013
            $email = filter_input(INPUT_SERVER, 'HTTP_X_USER_IDENTITY', FILTER_SANITIZE_EMAIL);

        } else {
            $email = null;
        }

        return $email;
    }

    /**
     * Returns the hostename of the email of the wanted user
     *
     * @param string $email the email of the user, would be used instead of $setting->getUser()->getUserEmail e.g. in Setting
     *
     * @return string|false
     */
    public function getHostname($email = null) {
        if(null === $email) {
            $email = $this->getEmail();
        }
        if(empty($email)) {
            return false;
        } else {
            return explode('@', $email)[1];
        }
    }
}