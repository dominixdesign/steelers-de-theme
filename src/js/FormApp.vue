<template>
  <div class="bg-white rounded-lg p-10 max-w-4xl m-auto shadow-box-circle col-span-8">
    <form @submit="handleSubmit">

      <!-- Defining Form Steps -->
      <FormSteps>

        <FormStep name="my_season_ticket" label="Meine Dauerkarte"
          :elements="['ticket_type', 'ticket_area', 'ticket_category', 'ticket_form', 'ticket_seats']" :labels="{
            next: 'Weiter',
          }" />

        <FormStep name="my_payment" label="Bezahlung" :elements="['ticket_payment']" :labels="{
            next: 'Weiter',
  previous: 'Zurück'
          }" />

        <FormStep name="my_information" label="Meine Kontaktdaten"
          :elements="['customer_data', 'customer_member', 'customer_eventim']" :labels="{
            next: 'Weiter',
  previous: 'Zurück'
          }" />

        <FormStep name="overview" label="Übersicht" :elements="['data_privacy', 'terms']" :labels="{
            next: 'Verbindlich bestellen',
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

        <RadiogroupElement name="ticket_form" :conditions="[['ticket_category', '!=', null]]" rules="required" :items="[
          { value: 'mobile', label: 'Mobile Dauerkarte', description: '(zur Ablage im Smartphone)' },
          { value: 'plastik', label: 'Klassische Plastikkarte' },
          { value: 'mobile_plastik', label: 'Klassische Plastikkarte + mobile Dauerkarte' },
        ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Dauerkartenform:</div>
          </template>
        </RadiogroupElement>

        <RadiogroupElement name="ticket_payment" rules="required" :items="[
  {
    value: 'ueberweisung', label: 'Überweisung', description: 'Überweisung auf das Konto der Steelers GmbH<br>Kreissparkasse Ludwigsburg, IBAN: DE91 6045 0050 0030 2168 19' },
  { value: 'gs', label: 'Bezahlung auf der Steelers-Geschäftsstelle (in bar oder mit EC-Karte)' },
        ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Bezahlung:</div>
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
          <TextElement name="customer_street" autocomplete="address-line1" rules="required" placeholder=" Straße"
            :columns="{
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
          <template #label>
            <div class="text-lg leading-tight mt-2">Mein Kontaktdaten:</div>
          </template>
        </GroupElement>

      </FormElements>

      <FormStepsControls />
    </form>
  </div>
</template>

<script>
import { Vueform, useVueform } from '@vueform/vueform'
import FormComponentSeat from "./FormComponentSeat.vue";
import FormComponentCategory from "./FormComponentCategory.vue";
import FormOverview from "./FormOverview.vue";

export default {
  mixins: [Vueform],
  setup: useVueform,
  methods: {
    onAreaChange() {
      this.el$('ticket_category').reset()
    },
    
  },
  computed: {
    selectedSeat() {
      return ''
    }
  },
  components: {
    FormComponentSeat,
    FormComponentCategory,
    FormOverview,
  },
}
</script>

<style>
.w-30 {
  width: 7.5rem;
}
</style>