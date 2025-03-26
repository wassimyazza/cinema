<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Illuminate\Support\Facades\Hash;

class UserServiceTest extends TestCase
{
    protected $userRepositoryMock;
    protected $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAllUsers()
    {
        $expectedUsers = [
            (object)['id' => 1, 'name' => 'John Doe'],
            (object)['id' => 2, 'name' => 'Jane Smith']
        ];

        $this->userRepositoryMock->shouldReceive('all')
            ->once()
            ->andReturn($expectedUsers);

        $result = $this->userService->getAllUsers();
        $this->assertEquals($expectedUsers, $result);
    }

    public function testGetUserById()
    {
        $expectedUser = (object)['id' => 1, 'name' => 'John Doe'];

        $this->userRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($expectedUser);

        $result = $this->userService->getUserById(1);
        $this->assertEquals($expectedUser, $result);
    }

    public function testCreateUser()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];

        $expectedUser = (object)array_merge($userData, ['id' => 1]);
        $expectedUser->password = Hash::make($userData['password']);

        $this->userRepositoryMock->shouldReceive('create')
            ->once()
            ->withArgs(function ($arg) use ($userData) {
                return $arg['name'] === $userData['name'] &&
                       $arg['email'] === $userData['email'] &&
                       Hash::check($userData['password'], $arg['password']);
            })
            ->andReturn($expectedUser);

        $result = $this->userService->createUser($userData);
        $this->assertEquals($expectedUser, $result);
    }

    public function testUpdateUser()
    {
        $userId = 1;
        $userData = [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com'
        ];

        $expectedUser = (object)array_merge($userData, ['id' => $userId]);

        $this->userRepositoryMock->shouldReceive('update')
            ->once()
            ->with($userId, $userData)
            ->andReturn($expectedUser);

        $result = $this->userService->updateUser($userId, $userData);
        $this->assertEquals($expectedUser, $result);
    }

    public function testDeleteUser()
    {
        $userId = 1;

        $this->userRepositoryMock->shouldReceive('delete')
            ->once()
            ->with($userId)
            ->andReturn(true);

        $result = $this->userService->deleteUser($userId);
        $this->assertTrue($result);
    }
}