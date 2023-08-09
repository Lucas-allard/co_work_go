<?php

namespace Security\Infrastructure\Service;

use Core\Presentation\Controller\RootController;
use Security\Domain\ValueObject\HashedPassword;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    const LOGIN_ROUTE = 'login';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $plainPassword = $request->request->get('password', '');
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new CustomCredentials(
                fn($credentials, UserInterface $user) => HashedPassword::fromHash($user->getPassword())->match($credentials),
                $plainPassword
            ),
            [
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token'))
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if (!$token->getUser()->getRoles()) {
            return new Response('User has no roles');
        }

        return new RedirectResponse(
            $this->urlGenerator->generate(RootController::class)
        );
    }

}