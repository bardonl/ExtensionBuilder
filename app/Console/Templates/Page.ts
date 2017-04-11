page = PAGE
page {

	# Favourites icon
		shortcutIcon = EXT:extension_name/Resources/Public/Images/favicon.ico

		headerData.100 = TEXT
		headerData.100 {
			value (
				<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/typo3conf/ext/extension_name/Resources/Public/Images/favicon-144x144.png" />
				<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/typo3conf/ext/extension_name/Resources/Public/Images/favicon-152x152.png" />
				<link rel="icon" type="image/png" href="/typo3conf/ext/extension_name/Resources/Public/Images/favicon-32x32.png" sizes="32x32" />
			)
		}

		meta {
			viewport = width=device-width, initial-scale=1
			language = {$extension_name.languages.nl.abbr}
			language.httpEquivalent = 1
			language-id = {$extension_name.languages.nl.uid}
		}

	# Favourites icon
	# shortcutIcon = EXT:extension_name/Resources/Public/Images/Favicon/favicon.ico

	10 = FLUIDTEMPLATE
	10 {
		extbase {
			pluginName = PageRenderer
			controllerExtensionName = DefaultTemplate
			controllerVendorName = Redkiwi
			controllerName = Page
			controllerActionName = render
		}

		dataProcessing {
			60 = Redkiwi\DefaultTemplate\DataProcessing\PageDataProcessor
		}

		layoutRootPaths {
			10 = EXT:extension_name/Resources/Private/Layouts
		}

		partialRootPaths {
			10 = EXT:extension_name/Resources/Private/Partials
		}

		templateRootPaths {
			10 = EXT:extension_name/Resources/Private/Templates/Page
		}

		templateName.cObject = CASE
		templateName.cObject {
			key.data = levelfield:-1, backend_layout_next_level, slide
			key.override.field = backend_layout

			pagets__default = TEXT
			pagets__default.value = Default

			default = TEXT
			default.value = Unknown
		}

		settings < extension_name
	}

	# CSS includes
	includeCSS {

	}

	includeJSFooterlibs {

	}

}
