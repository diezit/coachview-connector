<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Interfaces\AdresInterface;
use Diezit\CoachviewConnector\Interfaces\PersoonInterface;
use Illuminate\Support\Collection;

class Persoon extends CoachviewData implements PersoonInterface
{
    protected $id;
    protected $titel;
    protected $voorletters;
    protected $voornaam;
    protected $tussenvoegsels;
    protected $achternaam;
    protected $achterTitel;
    protected $adres;
    protected $factuurAdres;
    protected $emailAdres;
    protected $telefoonNummer;
    protected $geslacht;
    protected $geboorteDatum;
    protected $geboortePlaats;
    protected $inactief;

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Personen', $params);

        $response = [];
        foreach ($data as $coachViewPersoon) {
            $response[] = Persoon::fromCoachViewData($this->coachview, $coachViewPersoon);
        }

        return collect($response);
    }

    public function findByEmail($email): Collection
    {
        $params = $this->makeParams(['where' => 'email1='.$email]);
        $data = $this->coachview->getData('/api/v1/Personen', $params);

        $response = [];
        foreach ($data as $coachViewPersoon) {
            $response[] = Persoon::fromCoachViewData($this->coachview, $coachViewPersoon);
        }

        return collect($response);
    }

    public function getById(string $id): ?Persoon
    {
        $data = $this->coachview->getData('/api/v1/Personen/'.$id);
        return $this->fromCoachViewData($this->coachview, $data);
    }

    public static function fromCoachViewData($coachview, $coachViewPersoon): Persoon
    {
        return (new Persoon($coachview))
            ->setId($coachViewPersoon->id)
            ->setTitel($coachViewPersoon->titel)
            ->setVoorletters($coachViewPersoon->voorletters)
            ->setVoornaam($coachViewPersoon->voornaam)
            ->setTussenvoegsels($coachViewPersoon->tussenvoegsels)
            ->setAchternaam($coachViewPersoon->achternaam)
            ->setAchterTitel($coachViewPersoon->achterTitel)
            ->setInactief($coachViewPersoon->inactief)
            ->setAdres($coachViewPersoon->adres ? Adres::fromCoachViewData($coachview, $coachViewPersoon->adres) : null)
            ->setFactuurAdres(
                $coachViewPersoon->factuurAdres ? Adres::fromCoachViewData(
                    $coachview,
                    $coachViewPersoon->factuurAdres
                ) : null
            )
            ->setEmailAdres($coachViewPersoon->email1)
            ->setTelefoonNummer($coachViewPersoon->tel1)
            ->setGeslacht($coachViewPersoon->geslacht)
            ->setGeboortePlaats($coachViewPersoon->geboorteplaats)
            ->setGeboorteDatum($coachViewPersoon->geboortedatum);
    }

    public function submit(PersoonInterface $persoon)
    {
        $postData = [
            'titel' => $persoon->getTitel(),
            'voorletters' => $persoon->getVoorletters(),
            'voornaam' => $persoon->getVoornaam(),
            'tussenvoegsels' => $persoon->getTussenvoegsels(),
            'achternaam' => $persoon->getAchternaam(),
            'email1' => $persoon->getEmailAdres(),
            'tel1' => $persoon->getTelefoonNummer(),
        ];

        return $this->coachview->doRequest('/api/v1/Personen', 'POST', $postData);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(?string $titel): self
    {
        $this->titel = $titel;
        return $this;
    }

    public function getVoorletters(): ?string
    {
        return $this->voorletters;
    }

    public function setVoorletters(?string $voorletters): self
    {
        $this->voorletters = $voorletters;
        return $this;
    }

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(?string $voornaam): self
    {
        $this->voornaam = $voornaam;
        return $this;
    }

    public function getTussenvoegsels(): ?string
    {
        return $this->tussenvoegsels;
    }

    public function setTussenvoegsels(?string $tussenvoegsels): self
    {
        $this->tussenvoegsels = $tussenvoegsels;
        return $this;
    }

    public function getAchternaam(): ?string
    {
        return $this->achternaam;
    }

    public function setAchternaam(?string $achternaam): self
    {
        $this->achternaam = $achternaam;
        return $this;
    }

    public function getAchterTitel(): ?string
    {
        return $this->achterTitel;
    }

    public function setAchterTitel(?string $achterTitel): self
    {
        $this->achterTitel = $achterTitel;
        return $this;
    }

    public function getAdres(): ?AdresInterface
    {
        return $this->adres;
    }

    public function setAdres(?AdresInterface $adres): self
    {
        $this->adres = $adres;
        return $this;
    }

    public function getFactuurAdres(): ?AdresInterface
    {
        return $this->factuurAdres;
    }

    public function setFactuurAdres(?AdresInterface $factuurAdres): self
    {
        $this->factuurAdres = $factuurAdres;
        return $this;
    }

    public function getEmailAdres(): ?string
    {
        return $this->emailAdres;
    }

    public function setEmailAdres(?string $emailAdres): self
    {
        $this->emailAdres = $emailAdres;
        return $this;
    }

    public function getTelefoonNummer(): ?string
    {
        return $this->telefoonNummer;
    }

    public function setTelefoonNummer(?string $telefoonNummer): self
    {
        $this->telefoonNummer = $telefoonNummer;
        return $this;
    }

    public function getGeslacht(): ?string
    {
        return $this->geslacht;
    }

    public function setGeslacht(?string $geslacht): self
    {
        $this->geslacht = $geslacht;
        return $this;
    }

    public function getGeboorteDatum(): ?string
    {
        return $this->geboorteDatum;
    }

    public function setGeboorteDatum(?string $geboorteDatum): self
    {
        $this->geboorteDatum = $geboorteDatum;
        return $this;
    }

    public function getGeboortePlaats(): ?string
    {
        return $this->geboortePlaats;
    }

    public function setGeboortePlaats(?string $geboortePlaats): self
    {
        $this->geboortePlaats = $geboortePlaats;
        return $this;
    }

    public function getCategorieen(): array
    {
        $coachView = $this->getCoachview();
        $params = $this->makeParams(['PersoonId' => $this->getId()]);
        $coachViewData = $coachView->getData('/api/v1/Persoonscategorieen', $params);
        $categories = [];
        foreach ($coachViewData as $categoryField) {
            $categories[] = $categoryField->naam;
        }
        return $categories;
    }

    public function getInactief(): bool
    {
        return $this->inactief;
    }

    public function setInactief(?bool $inactief): self
    {
        $this->inactief = (bool)$inactief;
        return $this;
    }


}
