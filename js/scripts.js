document.addEventListener("DOMContentLoaded", function () {

    // 1. MÁSCARA DE CPF (Interatividade e Manipulação de DOM)
    // Seleciona automaticamente qualquer campo de CPF no sistema
    const cpfInputs = document.querySelectorAll('input[name="cpf"], input[name="visitante_cpf"]');

    cpfInputs.forEach(function (input) {
        input.addEventListener('input', function (e) {
            // Remove qualquer letra ou caractere especial digitado
            let value = e.target.value.replace(/\D/g, '');

            // Trava o limite em 11 números
            if (value.length > 11) value = value.slice(0, 11);

            // Injeta os pontos e o traço visualmente (000.000.000-00)
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            e.target.value = value;
        });
    });

    // 2. VALIDAÇÃO DE FORMULÁRIOS FRONT-END (Bloqueia CPF incompleto)
    const forms = document.querySelectorAll('form');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            // Procura se o formulário atual possui um campo de CPF
            const cpfInput = form.querySelector('input[name="cpf"], input[name="visitante_cpf"]');

            if (cpfInput) {
                let cpfLimpo = cpfInput.value.replace(/\D/g, '');

                // Se o usuário tentar enviar com menos de 11 números, o JS bloqueia
                if (cpfLimpo.length < 11) {
                    e.preventDefault(); // Cancela o envio para o PHP
                    alert("Atenção: O CPF deve conter exatos 11 números.");
                    cpfInput.style.borderColor = "red"; // Destaca o campo com erro
                    cpfInput.focus();
                } else {
                    cpfInput.style.borderColor = "#ccc"; // Remove o erro visual
                }
            }
        });
    });

    // 3. CONFIRMAÇÃO DE EXCLUSÃO (Interatividade)
    // Protege automaticamente qualquer formulário que vá para páginas de exclusão
    const formsExcluir = document.querySelectorAll('form[action*="excluir"]');

    formsExcluir.forEach(function (formExcluir) {
        formExcluir.addEventListener('submit', function (e) {
            const confirmacao = confirm("Tem certeza que deseja apagar este registro permanentemente?");
            if (!confirmacao) {
                e.preventDefault(); // Cancela a exclusão se o usuário clicar em "Cancelar"
            }
        });
    });

});