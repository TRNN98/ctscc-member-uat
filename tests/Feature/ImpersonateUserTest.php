<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImpersonateUserTest extends TestCase
{
    public function non_admin_user_cannot_access_impersonate_page()
    {
        $this->withExceptionHandling();

        $this->post('/api/member/member_status')
            ->assertRedirect('/home');
    }
}
