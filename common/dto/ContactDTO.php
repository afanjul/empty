<?php

namespace common\dto;

/**
 * ContactDTO - Data Transfer Object para contactos (clientes/proveedores)
 */
readonly class ContactDTO
{
    public function __construct(
        public int $contactId,
        public int $tenantId,
        public int $type,
        public ?int $role,
        public ?string $nifIdNumber,
        public ?string $vatIdNumber,
        public ?string $code,
        public string $fiscalName,
        public ?string $tradeName,
        public ?string $email,
        public ?string $mobile,
        public ?string $phone,
        public ?string $website,
        public ?string $languageId,
        public ?string $currencyId,
        public ?int $defaultPaymentMethodId,
        public ?int $defaultDueDays,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * Crea un DTO desde un modelo Contact
     */
    public static function fromModel(\common\models\Contact $contact): self
    {
        return new self(
            contactId: $contact->contact_id,
            tenantId: $contact->tenant_id,
            type: $contact->type,
            role: $contact->role,
            nifIdNumber: $contact->nif_id_number,
            vatIdNumber: $contact->vat_id_number,
            code: $contact->code,
            fiscalName: $contact->fiscal_name,
            tradeName: $contact->trade_name,
            email: $contact->email,
            mobile: $contact->mobile,
            phone: $contact->phone,
            website: $contact->website,
            languageId: $contact->language_id,
            currencyId: $contact->currency_id,
            defaultPaymentMethodId: $contact->default_payment_method_id,
            defaultDueDays: $contact->default_due_days,
            createdAt: $contact->created_at,
            updatedAt: $contact->updated_at,
        );
    }

    /**
     * Convierte el DTO a array
     */
    public function toArray(): array
    {
        return [
            'contact_id' => $this->contactId,
            'tenant_id' => $this->tenantId,
            'type' => $this->type,
            'type_label' => $this->getTypeLabel(),
            'role' => $this->role,
            'role_label' => $this->getRoleLabel(),
            'nif_id_number' => $this->nifIdNumber,
            'vat_id_number' => $this->vatIdNumber,
            'code' => $this->code,
            'fiscal_name' => $this->fiscalName,
            'trade_name' => $this->tradeName,
            'display_name' => $this->getDisplayName(),
            'email' => $this->email,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'website' => $this->website,
            'language_id' => $this->languageId,
            'currency_id' => $this->currencyId,
            'default_payment_method_id' => $this->defaultPaymentMethodId,
            'default_due_days' => $this->defaultDueDays,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * Obtiene la etiqueta del tipo
     */
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            1 => 'Organización',
            2 => 'Persona',
            default => 'Desconocido',
        };
    }

    /**
     * Obtiene la etiqueta del rol
     */
    public function getRoleLabel(): ?string
    {
        return match ($this->role) {
            1 => 'Cliente',
            2 => 'Proveedor',
            3 => 'Lead',
            4 => 'Deudor',
            5 => 'Acreedor',
            default => null,
        };
    }

    /**
     * Obtiene el nombre para mostrar
     */
    public function getDisplayName(): string
    {
        return $this->tradeName ?? $this->fiscalName;
    }
}
