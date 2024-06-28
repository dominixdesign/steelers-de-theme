<template>
  <Vueform @response="handleResponse" ref="form$">
    <div class="bg-white rounded-lg p-10 max-w-4xl m-auto shadow-box-circle col-span-12">

      <!-- Defining Form Steps -->
      <FormSteps @next="onNextStep">

        <FormStep name="my_season_ticket" label="Meine Dauerkarte"
          :elements="['ticket_type', 'ticket_area', 'ticket_category', 'ticket_form', 'ticket_form2', 'ticket_seats', 'ticket_seats_rollstuhl', 'ff']"
          :labels="{
            next: 'Weiter',
          }" />

        <FormStep name="my_payment" label="Bezahlung" :elements="['ticket_payment']" :labels="{
          next: 'Weiter',
          previous: 'Zurück'
        }" />

        <FormStep name="my_information" label="Meine Kontaktdaten"
          :elements="['customer_data', 'customer_last_season', 'customer_eventim']" :labels="{
            next: 'Weiter',
            previous: 'Zurück'
          }" />

        <FormStep name="overview" label="Übersicht" :elements="['final_overview']" :labels="{
          finish: 'Verbindlich bestellen',
          previous: 'Zurück'
        }" />
      </FormSteps>

      <!-- Defining form elements -->
      <FormElements>

        <RadiogroupElement name="ticket_type" rules="required" :items="[
          { value: 'plus', label: 'Dauerkarte <b>PLUS</b>', description: 'Alle Vorbereitungsspiele + alle Hauptrundenspiele + alle Playoff-Heimspiele' },
          { value: 'basic', label: 'Dauerkarte <b>BASIC</b>', description: 'Alle Hauptrundenspiele' },
        ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Ich möchte folgende Dauerkarte 2024/2025 rechtsverbindlich
              bestellen:</div>
          </template>
        </RadiogroupElement>

        <RadiogroupElement name="ticket_area" @change="onAreaChange" :conditions="[['ticket_type', '!=', null]]"
          rules="required" :items="[
            { value: 'stehplatz', label: 'Stehplatz', description: 'EgeTrans Block' },
            { value: 'sitzplatz', label: 'Sitzplatz' },
            { value: 'rollstuhl', label: 'Rollstuhlfahrer' },
          ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Mein gewünschter Bereich:</div>
          </template>
        </RadiogroupElement>

        <FormComponentCategory :conditions="[['ticket_area', '!=', null]]" name="ticket_category" />

        <GroupElement name="ticket_seats" :conditions="[['ticket_category', '!=', null], ['ticket_area', 'sitzplatz']]">
          <FormComponentSeat />
          <template #label>
            <div class="text-lg leading-tight mt-2">Mein Sitzplatz:</div>
          </template>
        </GroupElement>

        <GroupElement name="ticket_seats_rollstuhl"
          :conditions="[['ticket_category', '!=', null], ['ticket_area', 'rollstuhl']]">
          <SelectElement :name="'seat_rollstuhl_block'" rules="required" placeholder="Block" :native="false" :items="[
            'Block R1',
            'Block R3',
            'Block R4',
          ]" :columns="{
              container: 4,
              label: 12,
              wrapper: 12,
            }" />
          <template #label>
            <div class="text-lg leading-tight mt-2">Mein Platz:</div>
          </template>
        </GroupElement>

        <FormComponentFF />

        <RadiogroupElement name="ticket_payment" rules="required" :items="[
          {
            value: 'ueberweisung', label: 'Überweisung', description: 'Überweisung auf das Konto der Steelers GmbH<br>Kreissparkasse Ludwigsburg, IBAN: DE91 6045 0050 0030 2168 19'
          },
          { value: 'gs', label: 'Bezahlung auf der Steelers-Geschäftsstelle (in bar oder mit EC-Karte)' },
        ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Bezahlung:</div>
          </template>
          <template #after>
            <div class="mt-2">Der Dauerkartenverkauf ist unterteilt in zwei Verkaufsphasen:<br />
              <ul>
                <li>1. Phase: 01.07.2024 bis 31.07.2024 (Zahlungseingang muss bis spätestens 31.07.2024 erfolgen)</li>
                <li>2. Phase: 01.08.2024 bis 15.09.2024 (Zahlungseingang muss bis spätestens 15.09.2024 erfolgen)</li>
              </ul>
              Die Ausgabe der Dauerkarte (schätzungsweise ab Mitte August) erfolgt nur bei vorheriger Bezahlung
            </div>
          </template>
        </RadiogroupElement>

        <GroupElement name="customer_data">
          <TextElement name="customer_name" autocomplete="family-name" rules="required" placeholder="Nachname" :columns="{
            container: 6,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_firstname" autocomplete="given-name" placeholder="Vorname" :columns="{
            container: 6,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_street" autocomplete="address-line1" rules="required"
            placeholder="Straße und Hausnummer" :columns="{
              container: 12,
              label: 3,
              wrapper: 12,
            }" />
          <TextElement name="customer_plz" autocomplete="postal-code" rules="required" placeholder="PLZ" :columns="{
            container: 3,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_city" autocomplete="address-line2" rules="required" placeholder="Ort" :columns="{
            container: 9,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_phone" autocomplete="tel" placeholder="Telefon" :columns="{
            container: 6,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_email" autocomplete="email" rules="required" placeholder="E-Mail" :columns="{
            container: 6,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_birthday" autocomplete="bday" input-type="date" label="Geburtstag"
            placeholder="Geburtstag" :columns="{
            container: 6,
            label: 3,
            wrapper: 12,
          }" />
          <TextElement name="customer_member" input-type="number" rules="required"
            :conditions="[['ticket_category', '==', 'mitglied']]" placeholder="Mitgliedsnummer" :columns="{
              container: 6,
              label: 3,
              wrapper: 12,
            }" />
          <template #label>
            <div class=" text-lg leading-tight mt-2">Mein Kontaktdaten:
            </div>
          </template>
        </GroupElement>

        <RadiogroupElement name="customer_last_season" rules="required" :items="[
          { value: 'ja', label: 'Ja' },
          { value: 'nein', label: 'Nein' },
        ]" view="tabs">
          <template #label>
            <div class="text-lg leading-tight mt-8">Ich hatte in der Saison 2023/2024 bereits eine Dauerkarte:</div>
          </template>
        </RadiogroupElement>

        <GroupElement name="customer_eventim">
          <RadiogroupElement name="eventim" rules="required" :items="[
            { value: 'ja', label: 'Ja' },
            { value: 'nein', label: 'Nein' },
          ]" view="tabs">
            <template #label>
              <div class="text-lg leading-tight mt-8">Ich habe bereits ein Kundenkonto bei EVENTIM worüber ich die
                Möglichkeit hätte, Tickets im Onlineshop
                zu erwerben:</div>
            </template>
          </RadiogroupElement>

          <TextElement name="eventim_email" autocomplete="email"
            :conditions="[['customer_eventim.eventim', '==', 'ja']]"
            label="Hinterlegte E-Mailadresse meines EVENTIM-Kontos" rules="required" placeholder="EVENTIM" />
          <TextElement name="eventim_account" :conditions="[['customer_eventim.eventim', '==', 'ja']]"
            label="Meine 6-stellige EVENTIM Kundennummer:" placeholder="EVENTIM Kundennummer:">
            <template #info>
              *Die Kundennummer ist auf gekauften Online-Tickets (bzw. Rechnungen) abgebildet
            </template>
          </TextElement>

        </GroupElement>

        <GroupElement name="final_overview">
          <FormOverview />
        </GroupElement>

      </FormElements>

      <FormStepsControls />
    </div>
  </Vueform>
</template>

<script>
import { Vueform, useVueform } from '@vueform/vueform'
import FormComponentSeat from "./FormComponentSeat.vue";
import FormComponentCategory from "./FormComponentCategory.vue";
import FormComponentFF from "./FormComponentFF.vue";
import FormOverview from "./FormOverview.vue";


export default {
  mixins: [Vueform],
  setup: useVueform,
  methods: {
    onAreaChange() {
      this.$refs.form$.el$('ticket_category').reset()
    },
    onNextStep() {
      window.scrollTo(0,100)
    },
    handleResponse(response, form$) {
      if(response.status == 200) {
        form$.messageBag.append(`Danke für deine Bestellung!<br />Du solltest eine E-Mail bekommen haben mit einer Zusammenfassung deiner Bestellung. Wir werden deine Bestellung nun prüfen und nur im Falle von Problemen uns bei dir melden.`, 'message')
        this.$refs.form$.steps$.goTo('my_season_ticket')
        window.scrollTo(0, 0)
      } else {
        form$.messageBag.append(`Irgendetwas ist schief gelaufen. Bitte versuche es später erneut, oder wende die an ticketing@steelers.de`)

      }
    }
  },
  components: {
    FormComponentSeat,
    FormComponentCategory,
    FormComponentFF,
    FormOverview,
  }
}
</script>

<style>
.w-30 {
  width: 7.5rem;
}
</style>