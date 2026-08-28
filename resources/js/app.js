// Point d'entrée JS (Vite). Alpine.js est chargé via CDN dans les layouts
// pour rester simple ; à terme tu peux le remplacer par un import npm classique :
// import Alpine from 'alpinejs'; Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('input[type="password"]').forEach((input) => {
		const wrapper = document.createElement('div');
		wrapper.className = 'relative mt-1';
		input.parentNode.insertBefore(wrapper, input);
		wrapper.appendChild(input);

		input.classList.remove('mt-1');
		input.classList.add('pr-10');

		const button = document.createElement('button');
		button.type = 'button';
		button.className = 'absolute right-0 top-0 h-full px-3 text-flux-noir/40 hover:text-flux-bleu transition-colors';
		button.setAttribute('aria-label', 'Afficher le mot de passe');
		button.setAttribute('aria-pressed', 'false');
		button.innerHTML = '<i class="bi bi-eye" aria-hidden="true"></i>';

		button.addEventListener('click', () => {
			const isVisible = input.type === 'text';
			input.type = isVisible ? 'password' : 'text';
			button.setAttribute('aria-label', isVisible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
			button.setAttribute('aria-pressed', String(!isVisible));
			button.innerHTML = `<i class="bi bi-eye${isVisible ? '' : '-slash'}" aria-hidden="true"></i>`;
		});

		wrapper.appendChild(button);
	});
});
