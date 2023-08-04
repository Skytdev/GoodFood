<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Token'] = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'refresh_token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['RefreshToken'] = [
            'type' => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['Credentials'] = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'api',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'api',
                ],
            ],
        ];

        $docs['components']['schemas']['User'] = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'example' => 'test@gmail.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'api',
                ],
                'firstname' => [
                    'type' => 'string',
                    'example' => 'firstname',
                ],
                'lastname' => [
                    'type' => 'string',
                    'example' => 'lastname',
                ],
                'birthday' => [
                    'type' => 'date',
                    'example' => '31/10/2020',
                ],
            ],
        ];

        $tokenDocumentation = [
            'paths' => [
                '/api/employee/login_check' => [
                    'post' => [
                        'tags' => ['Connection'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Credentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/customer/login_check' => [
                    'post' => [
                        'tags' => ['Connection'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Credentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/token_refresh' => [
                    'post' => [
                        'tags' => ['Connection'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login with Refresh Token.',
                        'requestBody' => [
                            'description' => 'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/RefreshToken',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/employee/registration' => [
                    'post' => [
                        'tags' => ['Connection'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Register employee.',
                        'requestBody' => [
                            'description' => 'Create new Employee',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/User',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get Employee Info',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/User',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                '/api/customer/registration' => [
                    'post' => [
                        'tags' => ['Connection'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Register customer.',
                        'requestBody' => [
                            'description' => 'Create new Customer',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/User',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get Customer Info',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/User',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}
