# Laravel DTO Generator

Bu proje, Laravel 12 içerisinde **Data Transfer Object (DTO)** yapısını kolayca üretmek için geliştirdiğim özel bir Artisan komutunu içerir:  
`php artisan make:dto`

---

## 🚀 Nedir?

**DTO (Data Transfer Object)**, veriyi taşımak için kullanılan sade veri sınıflarıdır.  
Controller, Service, Repository katmanlarında karmaşık array’ler yerine tip güvenli ve düzenli sınıflar kullanmanı sağlar.

Bu projede oluşturduğum özel artisan komutu sayesinde tek satırla DTO sınıfı oluşturabilirsin.

---

## ⚙️ Kurulum
Öncelikle projeyi klonla ve bağımlılıkları yükle:
---
# Örnek DTO Sınıfı

```
readonly class DillerDto
{    
    public function __construct(public string $name, public string $code, public ?string $flag = null, public bool $isDefault = false, public bool $isActive = true) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'flag' => $this->flag,
            'is_default' => $this->isDefault,
            'is_active' => $this->isActive,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? '',
            code: $data['code'] ?? '',
            flag: $data['flag'] ?? null,
            isDefault: $data['is_default'] ?? false,
            isActive: $data['is_active'] ?? true
        );
    }
````	
