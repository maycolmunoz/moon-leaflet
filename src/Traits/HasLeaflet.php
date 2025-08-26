<?php

namespace MaycolMunoz\MoonLeaflet\Traits;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentAttributesBagContract;
use MoonShine\Support\AlpineJs;
use MoonShine\Support\VO\FieldEmptyValue;
use MoonShine\UI\Components\Link;

trait HasLeaflet
{
    public string $latitudeField = 'latitude';

    public string $longitudeField = 'longitude';

    protected ?ComponentAttributesBagContract $latitudeAttributes = null;

    protected ?ComponentAttributesBagContract $longitudeAttributes = null;

    public function getLatitudeField(): string
    {
        return $this->latitudeField;
    }

    public function getLongitudeField(): string
    {
        return $this->longitudeField;
    }

    public function LatitudeAttributes(array $attributes): static
    {
        $this->latitudeAttributes = $this->getAttributes()
            ->except(array_keys($attributes))
            ->merge($attributes)
            ->when(
                $this->latitudeAttributes,
                fn (ComponentAttributesBagContract $attributes) => $attributes->merge($this->latitudeAttributes->getAttributes())
            );

        return $this;
    }

    protected function reformatAttributes(
        ?ComponentAttributesBagContract $attributes = null,
        string $name = ''
    ): ComponentAttributesBagContract {
        $dataName = $this->getAttribute('data-name');

        return ($attributes ?? $this->getAttributes())
            ->except(['data-name'])
            ->when(
                $dataName,
                static fn (ComponentAttributesBagContract $attr): ComponentAttributesBagContract => $attr->merge([
                    'data-name' => str($dataName)->replaceLast('[]', "[$name]"),
                ])
            );
    }

    public function getLatitudeAttributes(): ComponentAttributesBagContract
    {
        return $this->reformatAttributes($this->latitudeAttributes, $this->getLatitudeField());
    }

    public function longitudeAttributes(array $attributes): static
    {
        $this->longitudeAttributes = $this->getAttributes()
            ->except(array_keys($attributes))
            ->merge($attributes)
            ->when(
                $this->longitudeAttributes,
                fn (ComponentAttributesBagContract $attributes) => $attributes->merge($this->longitudeAttributes->getAttributes())
            );

        return $this;
    }

    public function getLongitudeAttributes(): ComponentAttributesBagContract
    {
        return $this->reformatAttributes($this->longitudeAttributes, $this->getLongitudeField());
    }

    public function columns(string $latitudeField, string $longitudeField): static
    {
        $this->latitudeField = $latitudeField;
        $this->longitudeField = $longitudeField;

        return $this;
    }

    public function getNameDotLatitude(): string
    {
        return "{$this->getNameDot()}.{$this->getLatitudeField()}";
    }

    public function getNameDotLongitude(): string
    {
        return "{$this->getNameDot()}.{$this->getLongitudeField()}";
    }

    protected function reformatFilledValue(mixed $data): mixed
    {
        return $this->extractFromTo($data);
    }

    protected function prepareFill(array $raw = [], ?DataWrapperContract $casted = null, int $index = 0): mixed
    {
        $values = parent::prepareFill($raw, $casted);

        // try to get from array
        if ($values instanceof FieldEmptyValue) {
            $castedValue = $raw[$this->getColumn()] ?? false;
            $values = \is_array($castedValue)
                ? $castedValue
                : $raw;
        }

        if (empty($values[$this->getLatitudeField()]) && empty($values[$this->getLongitudeField()])) {
            return new FieldEmptyValue;
        }

        return $values;
    }

    protected function extractFromTo(array $data): array
    {
        return [
            $this->getLatitudeField() => $data[$this->getLatitudeField()] ?? data_get($this->getDefault(), $this->getLatitudeField(), $this->min),
            $this->getLongitudeField() => $data[$this->getLongitudeField()] ?? data_get($this->getDefault(), $this->getLongitudeField(), $this->max),
        ];
    }

    protected function resolveRawValue(): mixed
    {
        return $this->resolvePreview();
    }

    protected function resolvePreview(): Renderable|string
    {
        $value = $this->toFormattedValue();

        if (! $value) {
            return '';
        }

        $latitude = $value[$this->getLatitudeField()];
        $longitude = $value[$this->getLongitudeField()];

        return Link::make("https://www.google.com/maps?q={$latitude},{$longitude}", '')
            ->customAttributes([
                'title' => "lat: {$latitude}, lon: {$longitude}",
            ])
            ->icon('s.globe-americas')
            ->blank()
            ->render();
    }

    protected function resolveOnApply(): ?Closure
    {
        return function ($item) {
            $values = $this->getRequestValue();

            data_set($item, $this->getLatitudeField(), $values[$this->getLatitudeField()] ?? '');
            data_set($item, $this->getLongitudeField(), $values[$this->getLongitudeField()] ?? '');

            return $item;
        };
    }

    protected function getOnChangeEventAttributes(?string $url = null): array
    {
        if ($url) {
            $this->latitudeAttributes(
                AlpineJs::onChangeSaveField(
                    $url,
                    $this->getLatitudeField(),
                )
            );

            $this->longitudeAttributes(
                AlpineJs::onChangeSaveField(
                    $url,
                    $this->getLongitudeField(),
                )
            );
        }

        return [];
    }

    protected function prepareBeforeRender(): void
    {
        parent::prepareBeforeRender();

        $this->latitudeAttributes([
            'name' => $this->getNameAttribute($this->getLatitudeField()),
        ])->longitudeAttributes([
            'name' => $this->getNameAttribute($this->getLongitudeField()),
        ]);
    }

    public function getErrors(): array
    {
        $errors = collect(parent::getErrors());

        return [
            ...$errors,
            $this->getNameDot() => [
                ...(data_get($errors->undot()->toArray(), $this->getNameDotLatitude()) ?? []),
                ...(data_get($errors->undot()->toArray(), $this->getNameDotLongitude()) ?? []),
            ],
        ];
    }

    protected function resolveValue(): mixed
    {
        return $this->toValue();
    }
}
