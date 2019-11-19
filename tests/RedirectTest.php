<?php

namespace Neurony\Redirects\Tests;

use Neurony\Redirects\Exceptions\RedirectException;
use Neurony\Redirects\Models\Redirect;

class RedirectTest extends TestCase
{
    /** @test */
    public function it_redirects_a_request()
    {
        Redirect::create([
            'old_url' => 'old-url',
            'new_url' => 'new/url',
        ]);

        $response = $this->get('old-url');
        $response->assertRedirect('new/url');
    }

    /** @test */
    public function it_redirects_nested_requests()
    {
        Redirect::create([
            'old_url' => '1',
            'new_url' => '2',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('2');

        Redirect::create([
            'old_url' => '2',
            'new_url' => '3',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('3');

        $response = $this->get('2');
        $response->assertRedirect('3');

        Redirect::create([
            'old_url' => '3',
            'new_url' => '4',
        ]);

        $response = $this->get('1');
        $response->assertRedirect('4');

        $response = $this->get('2');
        $response->assertRedirect('4');

        $response = $this->get('3');
        $response->assertRedirect('4');

        Redirect::create([
            'old_url' => '4',
            'new_url' => '1',
        ]);

        $response = $this->get('2');
        $response->assertRedirect('1');

        $response = $this->get('3');
        $response->assertRedirect('1');

        $response = $this->get('4');
        $response->assertRedirect('1');
    }

    /** @test */
    public function it_guards_against_creating_redirect_loops()
    {
        $this->expectException(RedirectException::class);

        Redirect::create([
            'old_url' => 'same-url',
            'new_url' => 'same-url',
        ]);
    }
}
