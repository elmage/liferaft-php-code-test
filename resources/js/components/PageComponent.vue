<template>
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            <IntroComponent />
            <ContactFormComponent />
        </div>
    </div>
</template>

<script>
    import IntroComponent from "./IntroComponent";
    import ContactFormComponent from "./ContactFormComponent";

	export default {
		name: "PageComponent",
        components: {IntroComponent, ContactFormComponent}
	}
</script>
