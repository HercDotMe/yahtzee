<?php

namespace App\Service;

use App\DTO\User\UserCreate;
use App\DTO\User\UserUpdate;
use App\Entity\User;
use App\Exception\AlreadyExistsException;
use App\Exception\AtLeastOneExpectedException;
use App\Exception\DoesNotExist;
use App\Exception\ValidationException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
        $this->validator = $validator;
    }

    /**
     * @param UserCreate $dto
     * @return User
     *
     * @throws AlreadyExistsException|ValidationException
     */
    public function createUser(UserCreate $dto): User
    {
        // Check DTO Passes validation
        $errors = $this->validator->validate($dto, null, ['create']);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        // Check email not already registered
        $existingUser = $this->repository->findOneBy(['email' => $dto->email]);
        if ($existingUser) {
            throw new AlreadyExistsException('User already exists');
        }

        $user = new User();
        $user->setEmail($dto->email);
        $user->setPassword(password_hash($dto->password, PASSWORD_DEFAULT));
        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int $id
     * @return User
     */
    public function readUser(int $id): User
    {
        return $this->repository->find($id);
    }

    /**
     * @param int $id
     * @param UserUpdate $user
     * @return User
     * @throws DoesNotExist
     * @throws ValidationException
     */
    public function updateUser(int $id, UserUpdate $user): User
    {
        // Check DTO Passes validation
        $errors = $this->validator->validate($user, null, ['update']);

        // Check DTO has at least one property set
        if (empty($user->email) && empty($user->password)) {
            $errors->add(
                new ConstraintViolation('At least \'email\' or \'password\' are required.', null, [], null, 'email', null)
            );
            $errors->add(
                new ConstraintViolation('At least \'email\' or \'password\' are required.', null, [], null, 'password', null)
            );
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        // Check whether user exists
        $existingUser = $this->repository->find($id);
        if ($existingUser === null) {
            throw new DoesNotExist('User does not exist!');
        }

        if (!empty($user->email)) {
            $existingUser->setEmail($user->email);
        }

        if (!empty($user->password)) {
            $existingUser->setPassword(password_hash($user->password, PASSWORD_DEFAULT));
        }

        return $existingUser;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        // Check whether user exists
        $existingUser = $this->repository->find($id);
        if ($existingUser === null) {
            return false;
        }

        // Delete user
        $this->entityManager->remove($existingUser);
        $this->entityManager->flush();

        return true;
    }
}
