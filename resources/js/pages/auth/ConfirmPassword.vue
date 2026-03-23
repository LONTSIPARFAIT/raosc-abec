<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from '@/routes/password/confirm';
</script>

<template>
    <AuthLayout
        title="Confirmation du mot de passe"
        description="Zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer."
    >
        <Head title="Confirmation du mot de passe" />

        <Form
            v-bind="store.form()"
            reset-on-success
            v-slot="{ errors, processing }"
        >
            <div class="space-y-5">
                <div class="grid gap-2">
                    <Label for="password" class="text-sm font-medium">Mot de passe</Label>
                    <PasswordInput
                        id="password"
                        name="password"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                        required
                        autocomplete="current-password"
                        autofocus
                        placeholder="Votre mot de passe"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center">
                    <Button
                        type="submit"
                        class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                        :disabled="processing"
                        data-test="confirm-password-button"
                    >
                        <Spinner v-if="processing" />
                        Confirmer le mot de passe
                    </Button>
                </div>
            </div>
        </Form>
    </AuthLayout>
</template>