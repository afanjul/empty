<?php

namespace common\dto;

/**
 * TenantDTO - Data Transfer Object para tenants (accounts)
 */
readonly class TenantDTO
{
    public function __construct(
        public int $tenantId,
        public string $fiscalName,
        public ?string $tradeName,
        public string $subdomain,
        public int $status,
        public string $baseCurrencyId,
        public ?string $defaultLanguageId,
        public ?string $countryId,
        public string $timezone,
        public ?string $nifIdNumber,
        public ?string $vatIdNumber,
        public ?array $accountSettings,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * Crea un DTO desde un modelo Account
     */
    public static function fromModel(\common\models\Account $account): self
    {
        return new self(
            tenantId: $account->tenant_id,
            fiscalName: $account->fiscal_name,
            tradeName: $account->trade_name,
            subdomain: $account->subdomain,
            status: $account->status,
            baseCurrencyId: $account->base_currency_id,
            defaultLanguageId: $account->default_language_id,
            countryId: $account->country_id,
            timezone: $account->timezone,
            nifIdNumber: $account->nif_id_number,
            vatIdNumber: $account->vat_id_number,
            accountSettings: $account->account_settings,
            createdAt: $account->created_at,
            updatedAt: $account->updated_at,
        );
    }

    /**
     * Convierte el DTO a array
     */
    public function toArray(): array
    {
        return [
            'tenant_id' => $this->tenantId,
            'fiscal_name' => $this->fiscalName,
            'trade_name' => $this->tradeName,
            'subdomain' => $this->subdomain,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'base_currency_id' => $this->baseCurrencyId,
            'default_language_id' => $this->defaultLanguageId,
            'country_id' => $this->countryId,
            'timezone' => $this->timezone,
            'nif_id_number' => $this->nifIdNumber,
            'vat_id_number' => $this->vatIdNumber,
            'account_settings' => $this->accountSettings,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'is_active' => $this->isActive(),
        ];
    }

    /**
     * Obtiene la etiqueta del estado
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            1 => 'Prueba',
            2 => 'Activo',
            3 => 'Inactivo',
            4 => 'Cancelado',
            5 => 'Impago',
            default => 'Desconocido',
        };
    }

    /**
     * Verifica si está activo
     */
    public function isActive(): bool
    {
        return in_array($this->status, [1, 2]); // TRIAL o ACTIVE
    }

    /**
     * Obtiene configuración de Verifactu
     */
    public function getVerifactuSettings(): array
    {
        return $this->accountSettings['verifactu'] ?? [];
    }
}
