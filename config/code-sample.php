<?php
    // function getClient()
    // {
    //     $client = new Google_Client();
    //     $client->setApplicationName($this->projectName);
    //     $client->setScopes(SCOPES);
    //     $client->setAuthConfig($this->jsonKeyFilePath);
    //     $client->setRedirectUri($this->redirectUri);
    //     $client->setAccessType('offline');
    //     $client->setApprovalPrompt('force');

    //    // Load previously authorized credentials from a file.
    //    if (file_exists($this->tokenFile)) {
    //      $accessToken = json_decode(file_get_contents($this->tokenFile), 
    //      true);
    //     } else {
    //     // Request authorization from the user.
    //     $authUrl = $client->createAuthUrl();
    //     header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

    //     if (isset($_GET['code'])) {
    //         $authCode = $_GET['code'];
    //         // Exchange authorization code for an access token.
    //         $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    //         header('Location: ' . filter_var($this->redirectUri, 
    //         FILTER_SANITIZE_URL));
    //         if(!file_exists(dirname($this->tokenFile))) {
    //             mkdir(dirname($this->tokenFile), 0700, true);
    //         }

    //         file_put_contents($this->tokenFile, json_encode($accessToken));
    //     }else{
    //         exit('No code found');
    //     }
    // }
    // $client->setAccessToken($accessToken);

    // // Refresh the token if it's expired.
    // if ($client->isAccessTokenExpired()) {

    //     // save refresh token to some variable
    //     $refreshTokenSaved = $client->getRefreshToken();

    //     // update access token
    //     $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

    //     // pass access token to some variable
    //     $accessTokenUpdated = $client->getAccessToken();

    //     // append refresh token
    //     $accessTokenUpdated['refresh_token'] = $refreshTokenSaved;

    //     //Set the new acces token
    //     $accessToken = $refreshTokenSaved;
    //     $client->setAccessToken($accessToken);

    //     // save to file
    //     file_put_contents($this->tokenFile, 
    //    json_encode($accessTokenUpdated));
    // }
    // return $client;
