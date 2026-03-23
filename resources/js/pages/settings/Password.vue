<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { edit } from '@/routes/user-password';
import type { BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Paramètres du mot de passe',
        href: edit(),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres du mot de passe" />

        <h1 class="sr-only">Paramètres du mot de passe</h1>

        <SettingsLayout>
            <div class="space-y-6">
                <Heading
                    variant="small"
                    title="Modifier le mot de passe"
                    description="Assurez‑vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé."
                />

                <Form
                    v-bind="PasswordController.update.form()"
                    :options="{
                        preserveScroll: true,
                    }"
                    reset-on-success
                    :reset-on-error="[
                        'password',
                        'password_confirmation',
                        'current_password',
                    ]"
                    class="space-y-6"
                    v-slot="{ errors, processing, recentlySuccessful }"
                >
                    <div class="grid gap-2">
                        <Label for="current_password" class="text-sm font-medium">Mot de passe actuel</Label>
                        <PasswordInput
                            id="current_password"
                            name="current_password"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            autocomplete="current-password"
                            placeholder="Votre mot de passe actuel"
                        />
                        <InputError :message="errors.current_password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password" class="text-sm font-medium">Nouveau mot de passe</Label>
                        <PasswordInput
                            id="password"
                            name="password"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            autocomplete="new-password"
                            placeholder="Nouveau mot de passe"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation" class="text-sm font-medium">Confirmer le mot de passe</Label>
                        <PasswordInput
                            id="password_confirmation"
                            name="password_confirmation"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            autocomplete="new-password"
                            placeholder="Confirmez le nouveau mot de passe"
                        />
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button
                            type="submit"
                            :disabled="processing"
                            class="bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full px-6 py-2.5 shadow-sm transition-all"
                            data-test="update-password-button"
                        >
                            Enregistrer le mot de passe
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-show="recentlySuccessful"
                                class="text-sm text-emerald-600 dark:text-emerald-400"
                            >
                                Enregistré.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>