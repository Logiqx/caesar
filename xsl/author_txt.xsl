<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method="text"/>

<xsl:variable name='tab'><xsl:text>&#9;</xsl:text></xsl:variable>

<xsl:template match="author">
author<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="name"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="info"/>
	
<xsl:for-each select="email">
author_email<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/>
</xsl:for-each>

<xsl:for-each select="homepage">
author_homepage<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@status"/>
</xsl:for-each>

<xsl:for-each select="emulator_links">
<xsl:for-each select="emulator_link">
author_emulator_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>author
</xsl:for-each>
</xsl:for-each>

<xsl:for-each select="contribution_links">
<xsl:for-each select="emulator_link">
author_emulator_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>contributor
</xsl:for-each>
</xsl:for-each>

<xsl:for-each select="cpu_links">
<xsl:for-each select="library_link">
author_library_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>

<xsl:for-each select="sound_links">
<xsl:for-each select="library_link">
author_library_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>

<xsl:for-each select="tool_links">
<xsl:for-each select="tool_link">
author_tool_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>

</xsl:template>

</xsl:stylesheet>
