<?php

namespace App\Filament\Auth;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getBackToHomepageFormAction(),
            $this->getAuthenticateFormAction(),
        ];
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getMultiFactorChallengeFormActions(): array
    {
        return [
            $this->getBackToHomepageFormAction(),
            $this->getMultiFactorAuthenticateFormAction(),
        ];
    }

    protected function getBackToHomepageFormAction(): Action
    {
        return Action::make('backToHomepage')
            ->label('Go Back')
            ->color('gray')
            ->url('/');
    }
}
