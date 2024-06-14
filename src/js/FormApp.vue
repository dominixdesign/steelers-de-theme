<template>
  <div class="bg-white rounded-lg p-10 max-w-4xl m-auto shadow-box-circle col-span-8">
    <form @submit="handleSubmit">

      <!-- Defining Form Steps -->
      <FormSteps>

        <FormStep name="my_season_ticket" label="Meine Dauerkarte"
          :elements="['ticket_type', 'ticket_area', 'ticket_category', 'ticket_form']" :labels="{
            next: 'Weiter',
          }" />

        <FormStep name="my_seat" label="Mein Sitzplatz" :elements="['ticket_seats']"
          :labels="{next: 'Weiter', previous: 'Zurück' }" :conditions="[['ticket_area', 'sitzplatz'] ]" />

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
            { value: 'basic', label: 'Dauerkarte <b>BASIC</b>', description: 'Alle Hauptrundenspiele' },
            { value: 'plus', label: 'Dauerkarte <b>PLUS</b>', description: 'Alle Vorbereitungsspiele + alle Hauptrundenspiele + alle Playoff-Heimspiele' },
          ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Ich möchte folgende Dauerkarte 2024/2025 rechtsverbindlich
              bestellen:</div>
          </template>
        </RadiogroupElement>

        <RadiogroupElement name="ticket_area" rules="required" :items="[
            { value: 'stehplatz', label: 'Stehplatz', description: 'EgeTrans Block' },
            { value: 'sitzplatz', label: 'Sitzplatz' },
            { value: 'rollstuhl', label: 'Rollstuhlfahrer' },
          ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Mein gewünschter Bereich:</div>
          </template>
        </RadiogroupElement>

        <RadiogroupElement name="ticket_category" rules="required" :items="[
  { value: 'vollzahler', label: 'Vollzahler', description: ticket_price['vollzahler'] },
            { value: 'rentner', label: 'Rentner', description: 'XXX,XX €' },
            { value: 'Student', label: 'Student', description: 'XXX,XX €' },
            { value: 'Auszubildender', label: 'Auszubildender', description: 'XXX,XX €' },
            { value: 'Schüler über 18 Jahre', label: 'Schüler über 18 Jahre', description: 'XXX,XX €' },
            { value: 'SC Mitglied', label: 'SC Mitglied', description: 'XXX,XX €' },
            { value: 'Jugendlicher', label: 'Jugendlicher (13-17 Jahre)', description: 'XXX,XX €' },
            { value: 'Kind', label: 'Kind (8-12 Jahre)', description: 'XXX,XX €' },
            { value: 'Fan mit Behinderung', label: 'Fan mit Behinderung ab 50%', description: 'XXX,XX €' },
            { value: 'Familienkarte1', label: 'Familienkarte 1 (1 x Vollzahler + 2 Kinder/Jugendliche)', description: 'XXX,XX €' },
            { value: 'Familienkarte2', label: 'Familienkarte 2 (2 x Vollzahler + 1 Kind/Jugendlicher)', description: 'XXX,XX €' },
            { value: 'Familienkarte3', label: 'Familienkarte 3 (2 x Vollzahler + 2 Kinder/Jugendliche)', description: 'XXX,XX €' },
          ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Meine Kategorie:</div>
          </template>
        </RadiogroupElement>

        <RadiogroupElement name="ticket_form" rules="required" :items="[
          { value: 'mobile', label: 'Mobile Dauerkarte', description: '(zur Ablage im Smartphone)' },
          { value: 'plastik', label: 'Klassische Plastikkarte' },
          { value: 'mobile_plastik', label: 'Klassische Plastikkarte + mobile Dauerkarte' },
        ]" view="blocks">
          <template #label>
            <div class="text-lg leading-tight mt-2">Dauerkartenform:</div>
          </template>
        </RadiogroupElement>

        <GroupElement name="ticket_seats">
          <FormComponentSeat suffix="_1" />
          <FormComponentSeat suffix="_2"
            :conditions="[['ticket_category', ['Familienkarte1', 'Familienkarte2', 'Familienkarte3']]]" />
          <FormComponentSeat suffix="_3"
            :conditions="[['ticket_category', ['Familienkarte1', 'Familienkarte2', 'Familienkarte3']]]" />
          <FormComponentSeat suffix="_4" :conditions="[['ticket_category', 'Familienkarte3']]" />
        </GroupElement>

      </FormElements>

      <FormStepsControls />
    </form>
  </div>
</template>

<script>
import { inject, computed } from 'vue'
import { Vueform, useVueform } from '@vueform/vueform'
import FormComponentSeat from "./FormComponentSeat.vue";
import FormOverview from "./FormOverview.vue";

export default {
  mixins: [Vueform],
  setup: useVueform,
  components: {
    FormComponentSeat,
    FormOverview,
  },
  data: () => ({
    vueform: {
      size: 'lg',
      validateOn: 'change|step',
      overrideClasses: {
        RadioElement: {
          wrapper: 'flex border border-gray-300 py-4 px-4 items-center cursor-pointer dark:border-dark-700',
          text: 'w-full items-center',
        },
        CheckboxElement: {
          wrapper: 'flex border border-gray-300 py-4 px-4 items-center cursor-pointer dark:border-dark-700',
          text: 'w-full items-center',
        },
      },
      addClasses: {
        RadioElement: {
          input: 'mb-1',
        },
        CheckboxElement: {
          input: 'mb-1',
        },
      }
    },
    setup(props) {

      const prices =
        {
          basic: {
            stehplatz: {
              vollzahler: 10.0,
              rentner: 8.0,
              student: 8.0,
              azubi: 8.0,
              schueler: 8.0,
              mitglied: 8.0,
              jugendlicher: 6.0,
              kind: 4.0,
              behinderung: 2.0,
              familie1: 15.0,
              familie2: 20.0,
              familie3: 25.0,
            },
            sitzplatz: {
              vollzahler: 20.0,
              rentner: 18.0,
              student: 18.0,
              azubi: 18.0,
              schueler: 18.0,
              mitglied: 18.0,
              jugendlicher: 16.0,
              kind: 14.0,
              behinderung: 12.0,
              familie1: 45.0,
              familie2: 50.0,
              familie3: 55.0,
            }
          },
          plus: {
            stehplatz: {
              vollzahler: 12.0,
              rentner: 10.0,
              student: 10.0,
              azubi: 10.0,
              schueler: 10.0,
              mitglied: 10.0,
              jugendlicher: 8.0,
              kind: 6.0,
              behinderung: 4.0,
              familie1: 18.0,
              familie2: 22.0,
              familie3: 28.0,
            },
            sitzplatz: {
              vollzahler: 22.0,
              rentner: 20.0,
              student: 20.0,
              azubi: 20.0,
              schueler: 20.0,
              mitglied: 20.0,
              jugendlicher: 18.0,
              kind: 16.0,
              behinderung: 14.0,
              familie1: 55.0,
              familie2: 60.0,
              familie3: 65.0,
            }
          }
        }

      const form$ = inject('form$')
      
      const ticket_price = computed(() => {
        if (form$.value.data.ticket_type && form$.value.data.ticket_area) {
          return prices[form$.value.data.ticket_type][form$.value.data.ticket_area]
        }
        return {}
      })

      return {
        ticket_price
      }
    }
  })
}
</script>

<style>
.w-30 {
  width: 7.5rem;
}
</style>