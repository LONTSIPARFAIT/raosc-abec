<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { email } from '@/routes/password';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout
        title="Mot de passe oublié"
        description="Entrez votre adresse email pour recevoir un lien de réinitialisation"
    >
        <Head title="Mot de passe oublié" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-emerald-600 dark:text-emerald-400"
        >
            {{ status }}
        </div>

        <div class="space-y-6">
            <Form v-bind="email.form()" v-slot="{ errors, processing }">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-medium">Adresse email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        autofocus
                        placeholder="votre@email.com"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="mt-6 flex items-center justify-start">
                    <Button
                        type="submit"
                        class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                        :disabled="processing"
                        data-test="email-password-reset-link-button"
                    >
                        <Spinner v-if="processing" />
                        Envoyer le lien de réinitialisation
                    </Button>
                </div>
            </Form>

            <div class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                <span>Ou, retourner à </span>
                <TextLink :href="login()" class="text-raosc-green font-semibold hover:text-raosc-green/80">
                    la connexion
                </TextLink>
            </div>
        </div>
    </AuthLayout>
</template>