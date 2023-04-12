export default function mobileMenu() {
	let MENU_SELECTOR = ".thincrust-mobile-menu__nav";
	let MENU_VISIBLE_CLASS = "menu-visible";
	let BODY_MENU_VISIBLE_CLASS = "mobile-menu-visible";

	const MOBILE_MEDIA_QUERY = window.matchMedia("(min-width:960px)");

	let menu = document.querySelector(MENU_SELECTOR); // Early exit.

	if (!menu) {
		return;
	}

	const menuItemsHideFromTabIndex = () => {
		// By default, hide is true.
		let hide = true;

		// If the mobile menu is visible, don't hide.
		if (menu.classList.contains(MENU_VISIBLE_CLASS)) {
			hide = false;
		}

		// If we are above the mobile breakpoint, don't hide.
		if (MOBILE_MEDIA_QUERY.matches) {
			hide = false;
		}

		// Get all the links (and the occasional search field) and process their taxIndex's.
		let links = menu.querySelectorAll('a, input[type="search"], button');
		links.forEach(function (link) {
			if (true === hide) {
				link.tabIndex = -1;
			} else {
				link.tabIndex = 0;
			}
		});
	};

	const globalKeyDown = () => {
		var key = event.key;
		var KEY = key.toLowerCase();

		if (KEY === "escape" && menu.classList.contains(MENU_VISIBLE_CLASS)) {
			toggleMenu();
		}
	};

	const handleKeyDown = (event) => {
		var key = event.key;
		var target = event.target;

		var KEY = key.toLowerCase();

		if (KEY === "enter") {
			event.preventDefault();
			handleButtonDown();
		}
	};

	const handleButtonDown = () => {
		toggleMenu();
	};

	const toggleMenu = () => {
		if (menu.classList.contains(MENU_VISIBLE_CLASS)) {
			// Hide the menu.
			menu.classList.remove(MENU_VISIBLE_CLASS);
			document.body.classList.remove(BODY_MENU_VISIBLE_CLASS);
			menuItemsHideFromTabIndex();
		} else {
			// Show the menu.
			menu.classList.add(MENU_VISIBLE_CLASS);
			document.body.classList.add(BODY_MENU_VISIBLE_CLASS);
			menuItemsHideFromTabIndex();
		}
	};

	document.body.addEventListener("click", function (e) {
		if (
			e.target.classList.contains("mobile-menu-trigger") ||
			e.target.parentNode.classList.contains("mobile-menu-trigger")
		) {
			handleButtonDown();
		}
	});

	document.body.addEventListener("keydown", function (e) {
		if (
			e.target.classList.contains("mobile-menu-trigger") ||
			e.target.parentNode.classList.contains("mobile-menu-trigger")
		) {
			handleKeyDown(e);
		}
	});

	// SubMenu

	const handleKeyDownSub = (event) => {
		var key = event.key;
		var target = event.target;

		var KEY = key.toLowerCase();

		if (KEY === "enter") {
			event.preventDefault();
			handleButtonDownSub(event);
		}
	};

	const toggleMenuSub = (event) => {
		const submenu = event.target.closest(".menu-item");
		if (submenu.classList.contains(MENU_VISIBLE_CLASS)) {
			submenu.classList.remove(MENU_VISIBLE_CLASS);
		} else {
			submenu.classList.add(MENU_VISIBLE_CLASS);
		}
	};

	const handleButtonDownSub = (event) => {
		toggleMenuSub(event);
	};

	document.body.addEventListener("click", function (e) {
		if (
			e.target.classList.contains("menu-sub-menu-trigger") ||
			e.target.parentNode.classList.contains("menu-sub-menu-trigger")
		) {
			handleButtonDownSub(e);
		}
	});

	// Global
	document.removeEventListener("keydown", globalKeyDown);
	document.addEventListener("keydown", globalKeyDown);
	menuItemsHideFromTabIndex();
}
