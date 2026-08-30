document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll('[data-person-vcard-button]');
    [...buttons]?.forEach((button) => {
        const name = button.getAttribute('data-person-vcard-name');
        const position = button.getAttribute('data-person-vcard-position');
        const phone = button.getAttribute('data-person-vcard-phone');
        const email = button.getAttribute('data-person-vcard-email');

        var personCard = vCard.create(vCard.Version.FOUR);
        personCard.add(vCard.Entry.NAME, name);
        personCard.add(vCard.Entry.TITLE, position);
        personCard.add(vCard.Entry.PHONE, phone, vCard.Type.CELL);
        personCard.add(vCard.Entry.EMAIL, email, vCard.Type.WORK);
        var link = vCard.export(personCard, name, false);

        button.download = link.download;
        button.href = link.href;
    })
});
