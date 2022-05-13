<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class AttributeMutator
{
    /**
     * @var Factory
     */
    protected Factory $validator;

    /**
     * @var AttributeRepository
     */
    protected AttributeRepository $attributeRepository;

    /**
     * @param Factory $validator
     * @param Attribute $attribute
     */
    public function __construct(Factory $validator, AttributeRepository $attributeRepository)
    {
        $this->validator = $validator;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Attribute
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(?ObjectType $rootValue, array $args, GraphQLContext $context): Attribute
    {
        $this->validator->validate($args, [
            'name' => 'required|min:2|max:30'
        ]);

        $attribute = new Attribute();
        $attribute->name = $args['name'];
        $attribute->save();

        return $attribute;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return Attribute
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(?ObjectType $rootValue, array $args, GraphQLContext $context): Attribute
    {
        $this->validator->validate($args, [
            'name' => 'required|min:2|max:30'
        ]);

        $attribute = $this->attributeRepository->find($args['id']);
        $attribute->update([
            'id' => $args['id'],
            'name' => $args['name']
        ]);
        $attribute->save();

        return $attribute;
    }

    /**
     * @param ObjectType|null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @return void
     */
    public function destroy(?ObjectType $rootValue, array $args, GraphQLContext $context): bool
    {
        if ($attribute = $this->attributeRepository->find($args['id'])) {
            $attribute->delete();
            return true;
        }

        return false;
    }
}
