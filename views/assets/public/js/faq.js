async function fetchFaqs() {
    const faqContainer = document.querySelector('#faq');

    const response = await fetch('http://localhost/atelie/api/faqs');
    const faqs = await response.json();
    console.log(faqs.data)

    faqs.data.forEach(faq => {
        
        faqContainer.innerHTML += `
            <details class="faq-item">
                <summary>${faq.question}</summary>
                <p>
                    ${faq.answer}
                </p>
            </details>        
        `;

    });
}

fetchFaqs();