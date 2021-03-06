<?php

/**
 *
 * @file
 * Contains \Drupal\rules\Tests\ConfigEntityDefaultsTest.
 */


namespace Drupal\Tests\rules\Kernel;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests rules redirect action event subscriber.
 *
 * @coversDefaultClass \Drupal\rules\EventSubscriber\RedirectEventSubscriber
 * @group rules
 */
class RedirectEventSubscriberTest extends RulesDrupalTestBase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->installSchema('system', ['router', 'url_alias']);
    $this->container->get('router.builder')->rebuild();
  }

  /**
   * Test the response is a redirect if a redirect url is added tp the request.
   *
   * @covers ::checkRedirectIssued
   */
  public function testCheckRedirectIssued() {
    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface $http_kernel */
    $http_kernel = $this->container->get('http_kernel');

    $request = Request::create('/');
    $request->attributes->set('_rules_redirect_action_url', '/test/redirect/url');

    $response = $http_kernel->handle($request);

    $this->assertInstanceOf(RedirectResponse::class, $response, "The response is a redirect.");
    $this->assertEquals('/test/redirect/url', $response->getTargetUrl(), "The redirect target is the provided url.");
  }

}
