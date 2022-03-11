<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Interfaces\WebAanvraagInterface;

class WebAanvraag extends CoachviewData implements WebAanvraagInterface
{
    protected $referentieNrKlant;
    protected $opmerking;
    protected $uitvoeringstermijn;
    protected $aanvraagIsOrder = false;
    protected $bedrijf;
    protected $contactpersoon;
    protected $debiteur;
    protected $deelnemers = [];
    protected $contactpersoonIsLeidinggevende;
    protected $autorisatieEigenaar;
    protected $opleidingen;
    protected $vrijevelden;

    public function getReferentieNrKlant(): ?string
    {
        return $this->referentieNrKlant;
    }

    public function setReferentieNrKlant(string $referentieNrKlant): void
    {
        $this->referentieNrKlant = $referentieNrKlant;
    }

    public function getUitvoeringstermijn(): ?string
    {
        return $this->uitvoeringstermijn;
    }

    public function setUitvoeringstermijn(string $uitvoeringstermijn): self
    {
        $this->uitvoeringstermijn = $uitvoeringstermijn;
        return $this;
    }

    public function getOpmerking(): ?string
    {
        return $this->opmerking;
    }

    public function setOpmerking(string $opmerking): void
    {
        $this->opmerking = $opmerking;
    }

    public function getAantalPersonen(): int
    {
        return count($this->deelnemers);
    }

    public function getBedrijf(): string
    {
        return $this->bedrijf;
    }

    public function setBedrijf(string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getAanvraagIsOrder(): bool
    {
        return $this->aanvraagIsOrder;
    }

    public function setAanvraagIsOrder(bool $aanvraagIsOrder): self
    {
        $this->aanvraagIsOrder = $aanvraagIsOrder;
        return $this;
    }

    public function getDebiteur()
    {
        return $this->debiteur;
    }

    public function setDebiteur(Debtor $debiteur): self
    {
        $this->debiteur = $debiteur;
        return $this;
    }

    public function getOpleidingen()
    {
        return $this->opleidingen;
    }

    /**
     * @param  string  $opleidingId  CoachView ID of course
     */
    public function addOpleiding(string $opleidingId): self
    {
        $this->opleidingen[] = $opleidingId;
        return $this;
    }

    public function addDeelnemer(Persoon $deelnemer): self
    {
        $this->deelnemers[] = $deelnemer;
        return $this;
    }

    public function setContactpersoon(Persoon $person)
    {
        $this->contactpersoon = $person;
    }

    public function getContactpersoon()
    {
        return $this->contactpersoon;
    }

    public function submit(WebAanvraagInterface $webAanvraag)
    {
        $postData = [
            'referentieNrKlant' => $webAanvraag->getReferentieNrKlant(),
            'opmerking' => $webAanvraag->getOpmerking(),
            'aantalPersonen' => $webAanvraag->getAantalPersonen(),
            'uitvoeringstermijn' => $webAanvraag->getUitvoeringstermijn(),
            'aanvraagIsOrder' => $webAanvraag->getAanvraagIsOrder(),
            'opleidingen' => $webAanvraag->getOpleidingen(),
            'contactpersoon' => $webAanvraag->getContactpersoon()->toArray(),
            'bedrijf' => $webAanvraag->getBedrijf() ? $webAanvraag->getBedrijf()->toArray() : null,
        ];

        return $this->coachview->doRequest('/api/v1/Webaanvragen', 'POST', $postData);
    }

    public function getVrijevelden()
    {
        return $this->vrijevelden;
    }

    public function getContactpersoonIsLeidinggevende()
    {
        return $this->contactpersoonIsLeidinggevende;
    }

    public function getAutorisatieEigenaar()
    {
        return $this->autorisatieEigenaar;
    }

    public function getDeelnemers(): array
    {
        return $this->deelnemers;
    }
}
