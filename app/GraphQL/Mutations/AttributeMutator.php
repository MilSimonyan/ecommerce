<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
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

        $attribute = $this->attributeRepository->model();
        $attribute->user_id = auth()->user()->id;
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
            'name' => 'required|min:2|max:30',
            'id' => ['required',
        Rule::exists('attributes', 'id')->where(
            fn(Builder $query) => $query->where('user_id', auth()->user()->id)
        )],
        ]);

        $attribute = $this->attributeRepository->find($args['id']);

        $attribute->id = Arr::get($args, 'id', $attribute->id);
        $attribute->name = Arr::get($args, 'name', $attribute->name);

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
        $attribute = $this->attributeRepository->find($args['id']);

        if ($attribute && $attribute->user_id == auth()->user()->id) {
            $attribute->delete();
            return true;
        }

        return false;
    }
}
