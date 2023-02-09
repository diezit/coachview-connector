<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Diezit\CoachviewConnector\Interfaces\OpleidingInterface;
use Diezit\CoachviewConnector\Interfaces\OpleidingsonderdeelInterface;
use Illuminate\Support\Collection;

class Opleidingsonderdeel extends CoachviewData implements OpleidingsonderdeelInterface
{
    use FreeFieldsTrait {
        getFreeFields as protected traitGetFreeFields;
    }

    /** @var null|string */
    protected $id;

    /** @var null|string */
    protected $code;

    /** @var null|string */
    protected $naam;

    /** @var null|string */
    protected $omschrijving;

    /** @var null|Carbon */
    protected $startDatum;

    /** @var null|Carbon */
    protected $eindDatum;

    /** @var null|string */
    protected $locatie;

    /** @var null|OpleidingInterface */
    protected $opleiding;

    public function count(): ?int
    {
        return $this->coachview->getRowCount('/api/v1/Opleidingsonderdelen');
    }

    /**
     * @param  int|null  $offset
     * @param  int|null  $limit
     *
     * @return Collection|Opleidingsonderdeel[]
     */
    public function all(int $offset = null, int $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit, 'InclusiefDirecteRelaties' => 'true', 'InclusiefExtraVelden' => 'true']);
        $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen', $params);

        $response = [];
        foreach ($data ?? [] as $coachViewOpleidingsonderdeel) {
            $response[] = $this->getPlanningsItemFromCoachViewData($coachViewOpleidingsonderdeel);
        }

        return collect($response);
    }

    /**
     * @param  string  $opleidingId
     * @param  int|null  $offset
     * @param  int|null  $limit
     *
     * @return Collection|Opleidingsonderdeel[]
     */
    public function allByOpleidingId(string $opleidingId, int $offset = null, int $limit = null): Collection
    {
        $params = $this->makeParams(['where' => 'opleidingId='.$opleidingId, 'skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen', $params);

        $response = [];
        foreach ($data as $coachViewOpleidingsonderdeel) {
            $response[] = $this->getPlanningsItemFromCoachViewData($coachViewOpleidingsonderdeel);
        }

        return collect($response);
    }

    public function hydrate(object $coachViewOpleidingsonderdeel): Opleidingsonderdeel
    {
        $this
            ->setId($coachViewOpleidingsonderdeel->id)
            ->setCode($coachViewOpleidingsonderdeel->code)
            ->setNaam($coachViewOpleidingsonderdeel->naam)
            ->setOmschrijving($coachViewOpleidingsonderdeel->omschrijving)
            ->setStartDatum(new Carbon($coachViewOpleidingsonderdeel->datumTijdVan))
            ->setEindDatum(new Carbon($coachViewOpleidingsonderdeel->datumTijdTot))
        ;
        if ($coachViewOpleidingsonderdeel->locatie && $coachViewOpleidingsonderdeel->locatie->bedrijf) {
            $this->setLocatie($coachViewOpleidingsonderdeel->locatie->bedrijf->naam);
        }
        if ($coachViewOpleidingsonderdeel->opleiding) {
            $opleiding = new Opleiding($this->coachview);
            $opleiding->hydrate($coachViewOpleidingsonderdeel->opleiding);
            $this->setOpleiding($opleiding);
        }

        return $this;
    }

    protected function getPlanningsItemFromCoachViewData($coachViewOpleidingsonderdeel): Opleidingsonderdeel
    {
        return (new Opleidingsonderdeel($this->coachview))->hydrate($coachViewOpleidingsonderdeel);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Opleidingsonderdeel
    {
        $this->id = $id;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): Opleidingsonderdeel
    {
        $this->code = $code;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(?string $naam): Opleidingsonderdeel
    {
        $this->naam = $naam;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(?string $omschrijving): Opleidingsonderdeel
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    public function getStartDatum(): ?Carbon
    {
        return $this->startDatum;
    }

    public function setStartDatum(?Carbon $startDatum): Opleidingsonderdeel
    {
        $this->startDatum = $startDatum;

        return $this;
    }

    public function getEindDatum(): ?Carbon
    {
        return $this->eindDatum;
    }

    public function setEindDatum(?Carbon $eindDatum): Opleidingsonderdeel
    {
        $this->eindDatum = $eindDatum;

        return $this;
    }

    public function getLocatie(): ?string
    {
        return $this->locatie;
    }

    public function setLocatie(?string $locatie): Opleidingsonderdeel
    {
        $this->locatie = $locatie;

        return $this;
    }

    public function getOpleiding(): ?OpleidingInterface
    {
        return $this->opleiding;
    }

    public function setOpleiding(?OpleidingInterface $opleiding): Opleidingsonderdeel
    {
        $this->opleiding = $opleiding;

        return $this;
    }

    public function getDetails(): OpleidingsonderdeelInterface
    {
        return $this->getById($this->getId());
    }

    public function getByCode(string $code): ?Opleidingsonderdeel
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen', $params);

        foreach ($data as $coachViewCourseTemplate) {
            return $this->hydrate($coachViewCourseTemplate);
        }

        return null;
    }

    public function getById(string $id): ?Opleidingsonderdeel
    {
        $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen/'.$id);
        return $this->hydrate($data);
    }

    /**
     * @return array|FreeField[]
     */
    public function getFreeFields(): array
    {
        return $this->traitGetFreeFields('/api/v1/Opleidingsonderdelen/Vrijevelden');
    }
}
