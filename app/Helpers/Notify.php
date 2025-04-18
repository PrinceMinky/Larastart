<?php

namespace App\Helpers;

use Flux\Flux;
use InvalidArgumentException;

final class Notify
{
    private ?string $text = null;

    private ?string $heading = null;

    private ?string $variant = null;

    private string $position = 'bottom right';

    private string $duration = '5000';

    private const VALID_POSITIONS = [
        'bottom right',
        'bottom left',
        'top right',
        'top left',
    ];

    private const VALID_VARIANTS = [
        'success',
        'warning',
        'danger',
        null,
    ];

    /**
     * Set notification heading
     *
     * @return $this
     */
    public function heading(?string $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Set notification text content
     *
     * @return $this
     */
    public function text(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set notification position
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function position(string $position): self
    {
        if (! in_array($position, self::VALID_POSITIONS)) {
            throw new InvalidArgumentException(
                "Invalid position: $position. Valid positions are: ".
                implode(', ', self::VALID_POSITIONS)
            );
        }

        $this->position = $position;

        return $this;
    }

    /**
     * Set notification variant/style
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function variant(?string $variant): self
    {
        if ($variant === null) {
            $this->variant = null;

            return $this;
        }

        if (! in_array($variant, self::VALID_VARIANTS)) {
            throw new InvalidArgumentException(
                "Invalid variant: $variant. Valid variants are: ".
                implode(', ', self::VALID_VARIANTS)
            );
        }

        $this->variant = $variant;

        return $this;
    }

    /**
     * Set notification duration in milliseconds
     *
     * @return $this
     */
    public function duration(string|int $duration): self
    {
        if (! is_numeric($duration) || $duration < 0) {
            throw new InvalidArgumentException("Duration must be a positive number, got: $duration");
        }
        $this->duration = (string) $duration;

        return $this;
    }

    /**
     * For debugging - die and dump notification configuration
     */
    public function dd(): never
    {
        dd([
            'text' => $this->text,
            'heading' => $this->heading,
            'variant' => $this->variant,
            'position' => $this->position,
            'duration' => $this->duration,
        ]);
    }

    /**
     * For debugging - dump notification configuration
     */
    public function dump(): void
    {
        dump([
            'text' => $this->text,
            'heading' => $this->heading,
            'variant' => $this->variant,
            'position' => $this->position,
            'duration' => $this->duration,
        ]);
    }

    /**
     * Display the toast notification
     *
     * @throws InvalidArgumentException if required fields are missing
     */
    public function toast(): void
    {
        $this->validateRequiredFields();

        Flux::toast(
            text: $this->text,
            heading: $this->heading,
            variant: $this->variant,
            position: $this->position,
            duration: $this->duration,
        );
    }

    /**
     * Validate that required fields are set before displaying toast
     *
     * @throws InvalidArgumentException
     */
    private function validateRequiredFields($type = 'toast'): void
    {
        if ($type === 'toast' && $this->text === null) {
            throw new InvalidArgumentException('Notification text is required');
        }
    }
}
