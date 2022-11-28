# NFT Pro - Backend (PHP)

Laravel 9.*

PHP 8.*;

Laravel Nova for admin dashboard (4.*)

Laravel Sanctum for token based authentication (2.*)

- simplito/elliptic-php, kornrunner/keccak for login with crypto wallet by message signature
- spatie/laravel-event-sourcing to track user balance changes
- in-app purchases based on webhooks from RevenueCat
- AWS SES (email notifications) and FCM (push notifications)
- Redis-driven queues for notifications sending & status checking of minted/transfered NFT's (based on trasnactions in etherscan and polygonscan)
