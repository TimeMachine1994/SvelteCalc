<script>
    import { writable } from 'svelte/store';

    const currentPage = writable(1);
    let livestreamAtFuneralHome = null;
    let selectedPackage = '';
    const packagePrices = { 'Solo': 399, 'Anywhere': 499, 'Legacy': 799 };
    let masterPrice = 0;

    let formData = {
        lovedOnesName: '',
        livestreamDate: '',
        yourName: '',
        email: '',
        phoneNumber: ''
    };

    function selectPackage(packageName) {
        selectedPackage = packageName;
        masterPrice = packagePrices[packageName];
    }

    function submitForm() {
        // Logic to handle form submission
        // Send data to a Google spreadsheet
    }
</script>

{#if $currentPage === 1}
    <div>
        <input type="text" bind:value={formData.lovedOnesName} placeholder="Loved One's Name" />
        <input type="text" bind:value={formData.livestreamDate} placeholder="Livestream Date" />
        <input type="text" bind:value={formData.yourName} placeholder="Your Name" />
        <input type="text" bind:value={formData.email} placeholder="Email" />
        <input type="text" bind:value={formData.phoneNumber} placeholder="Phone Number" />
        <button on:click={() => livestreamAtFuneralHome = true}>Yes</button>
        <button on:click={() => livestreamAtFuneralHome = false}>No</button>
        <p>Are we livestreaming at the funeral home?</p>
        <button on:click={() => currentPage.set(2)}>Next</button>
    </div>
{:else}
    <div>
        <div>
            {#if livestreamAtFuneralHome !== false}
                <button on:click={() => selectPackage('Solo')}>Solo</button>
            {/if}
            <button on:click={() => selectPackage('Anywhere')}>Anywhere</button>
            <button on:click={() => selectPackage('Legacy')}>Legacy</button>
        </div>
        <div>
            <p>Your Loved One's Custom Link: Tributestream.com/{formData.lovedOnesName}</p>
            <p>Master Price: ${masterPrice}</p>
            <p>Selected Package: {selectedPackage}</p>
            <input type="file" />
            <button on:click={submitForm}>Book Now</button>
        </div>
    </div>
{/if}


<!--
Chat GPT Prompt for code: Ok perfect, now let's spice things up a little bit. We are going to create a two page application with a cart display like we did in svlete, but with a ton of modifications.
Step one: the first page is going to have form questions for the following: Loves Ones Name (text field) Livestream Date (text field) Your Name (text field) Email (text field) Phone Number (text field) and a question with two buttons side by side, Yes, or No- the question is "Are we livestreaming at the funeralhome?"
Then there is a next button, which will load the "second page" of our SPA.
The next page should be devided in half with form questions on the left half and a dynamic master price and cart display centered on the right hand side.
Also on the right hand side above the master price is a Text with a modified display of the Loved Ones Name on page 1. To be more specific, the Text will read: "Your Loved Ones ustom Link <br> Tributestream.com/loved_ones_Name"
Under the dynamic cart should be a click to upload an image button that prompts for an upload, and be low that a "book now" button that sends all the data to a google spread sheet for further processing.
Now, I will specificy the breakdown of the forms on the left side. It should start with the text "Chose your Tributestream"
Based on the "Are we livestreaming atthe funeralhome?" question we will present either three or two button options side by side, "Solo" "Anywhere" or "Legacy", dropping the Solo if the answer to the question "Are we livestreaming at the funeralhome?" is "No".
Then, based on the users input, we will update the cart and master price on the right. 
The values are as follows: Solo, $399, Anywher, $499, and Legacy $799. The master price should update with the just the price, and only one package can be selected. Further more, the cart should display both the name and price of the package.
This should be setup so we can add more questions below the packges with ease. 
Write this in svelte. 
-->