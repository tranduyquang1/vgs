@include('admin.pages.settings.email.account', ['item' => $item])
@include('admin.pages.settings.email.bcc', ['emailBcc' => $emailBcc])
@include('admin.pages.settings.email.template', ['emailTemplate' => $emailTemplate])

<style>
    input, textarea {
        text-align: left !important;
    }
</style>