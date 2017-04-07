config {
# HTML rendering & processing
	doctype = html5
	disablePrefixComment = 1
	headerComment (
	========================================================
	Site creation and TYPO3 integration by Redkiwi Rotterdam
	www.redkiwi.nl
	========================================================
)
	htmlTag_setParams = xmlns="http://www.w3.org/1999/xhtml"
	removeDefaultJS = external
	spamProtectEmailAddresses = 1
	xhtml_cleaning = all
	xmlprologue = none

    # Nice generated URLs
	tx_realurl_enable = {$extension_name.realurl.enable}
	# Link & URL handling
	absRefPrefix = /
	prefixLocalAnchors = all
	fileTarget = _blank
	simulateStaticDocuments = 0
	typolinkCheckRootline = 1
	typolinkEnableLinksAcrossDomains = 1
	uniqueLinkVars = 1

	# Page title
	pageTitleFirst = 1
	pageTitleSeparator = |
	pageTitleSeparator.noTrimWrap = | | |

	# Language & locale handling
	sys_language_overlay = hideNonTranslated
	sys_language_mode = content_fallback
	sys_language_uid = {$extension_name.languages.nl.uid}
	language = {$extension_name.languages.nl.abbr}
	locale_all = {$extension_name.languages.nl.code}
	htmlTag_langKey = {$extension_name.languages.nl.abbr}

	# Disable CSS compression
	compressCss = 0
	compressJs = 0
	minifyCss = 0
	minifyJs = 0
	concatenateCss = 0
	concatenateJs = 0

	# Allow indexing
	index_enable = 1

	# Character sets
	renderCharset = utf-8
	metaCharset = utf-8
}

[applicationContext = Development*]
config {
	no_cache = 1
}
[global]
