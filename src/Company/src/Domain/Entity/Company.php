<?php

namespace Company\Domain\Entity;

use Company\Domain\Repository\CompanyRepositoryInterface;
use Company\Domain\ValueObject\OPTIONAL_FEATURE;
use Core\Domain\Contract\Enableable\EnableableInterface;
use Core\Domain\Contract\Enableable\EnableableTrait;
use Core\Domain\Contract\Imageable\MuliImageable\MultiImageableInterface;
use Core\Domain\Contract\Imageable\MuliImageable\MultiImageableTrait;
use Core\Domain\Contract\Internationalizable\InternationalizableInterface;
use Core\Domain\Contract\Internationalizable\InternationalizableTrait;
use Core\Domain\Contract\Phoneable\PhoneableInterface;
use Core\Domain\Contract\Phoneable\PhoneableTrait;
use Core\Domain\Contract\Sluggable\SluggableInterface;
use Core\Domain\Contract\Sluggable\SluggableTrait;
use Core\Domain\Contract\Ulidable\UlidableInterface;
use Core\Domain\Contract\Ulidable\UlidableTrait;
use Doctrine\ORM\NoResultException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use function Symfony\Component\String\u;

class Company implements UlidableInterface, EnableableInterface, PhoneableInterface, MultiImageableInterface, InternationalizableInterface, SluggableInterface
{
    use UlidableTrait;
    use EnableableTrait;
    use PhoneableTrait;
    use MultiImageableTrait;
    use InternationalizableTrait;
    use SluggableTrait {
        setSlug as setSluggableSlug;
    }

    private string $name;

    /** @var array<OPTIONAL_FEATURE> */
    private array $optionalFeatures = [];

    public function __construct()
    {
    }

    public static function create(
        string                     $id,
        string                     $name,
        string                     $currency,
        string                     $locale,
        string                     $timezone,
        CompanyRepositoryInterface  $companyRepository,
        ?string                    $slug = null
    ): self
    {
        return (new self())
            ->setId($id)
            ->setName($name)
            ->setCurrency($currency)
            ->setLocale($locale)
            ->setTimezone($timezone)
            ->setSlug($slug, $companyRepository);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->getSlug() ?? '';
    }

    public function setSlug(?string $slug, CompanyRepositoryInterface $companyRepository): self
    {
        if (null === $slug) {
            $slug = (new AsciiSlugger())->slug(u($this->getName())->lower())->toString();
        }

        if ($slug !== $this->getSlug()) {
            while (!self::assertSlugUniqueness($slug, $companyRepository)) {
                $slug .= random_int(0, 9);
            }
        }

        return $this->setSluggableSlug($slug);
    }

    private static function assertSlugUniqueness(string $slug, CompanyRepositoryInterface $companyRepository): bool
    {
        try {
            null === $companyRepository->findOneBySlug($slug);

            return false;
        } catch (NoResultException $ex) {
            return true;
        }
    }
    public function getSluggableFields(): array
    {
        return [$this->getName()];
    }

    public function hasOptionalFeature(OPTIONAL_FEATURE $optionalFeature): bool
    {
        return in_array($optionalFeature, $this->optionalFeatures);
    }

    public function addOptionalFeature(OPTIONAL_FEATURE $optionalFeature): self
    {
        if (!$this->hasOptionalFeature($optionalFeature)) {
            $this->optionalFeatures[] = $optionalFeature;
        }

        return $this;
    }

    public function removeOptionalFeature(OPTIONAL_FEATURE $optionalFeature): self
    {
        if ($this->hasOptionalFeature($optionalFeature)) {
            $this->optionalFeatures = array_filter($this->optionalFeatures, function (OPTIONAL_FEATURE $currentOptionalFeature) use ($optionalFeature) {
                return $currentOptionalFeature !== $optionalFeature;
            });
        }

        return $this;
    }
}