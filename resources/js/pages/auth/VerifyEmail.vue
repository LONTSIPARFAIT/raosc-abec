<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import { send } from '@/routes/verification';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout
        title="Vérification de l'adresse email"
        description="Veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer."
    >
        <Head title="Vérification email" />

        <div
            v-if="status === 'verification-link-sent'"
            class="mb-4 text-center text-sm font-medium text-emerald-600 dark:text-emerald-400"
        >
            Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
        </div>

        <Form
            v-bind="send.form()"
            class="space-y-6 text-center"
            v-slot="{ processing }"
        >
            <Button
                type="submit"
                :disabled="processing"
                class="bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full px-6 py-2.5 shadow-sm transition-all"
            >
                <Spinner v-if="processing" />
                Renvoyer l'email de vérification
            </Button>

            <TextLink
                :href="logout()"
                as="button"
                class="mx-auto block text-sm text-raosc-green font-semibold hover:text-raosc-green/80 transition-colors"
            >
                Se déconnecter
            </TextLink>
        </Form>
    </AuthLayout>
</template>
