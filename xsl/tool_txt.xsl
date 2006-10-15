<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method="text"/>

<xsl:variable name='tab'><xsl:text>&#9;</xsl:text></xsl:variable>

<xsl:template match="tool">
tool<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@type"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="name"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="version"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="date"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="comment"/>
<xsl:for-each select="homepage">
tool_homepage<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@status"/>
</xsl:for-each>
<xsl:for-each select="author_link">
tool_author_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
<xsl:for-each select="emulator_links">
<xsl:for-each select="emulator_link">
tool_emulator_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="library_links">
<xsl:for-each select="library_link">
tool_library_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="files">
<xsl:for-each select="file">
tool_file<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@name"/>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

<xsl:template match="tool_contents">
tool_contents<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="title"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="comment"/>
<xsl:for-each select="tool_links">
<xsl:for-each select="tool_link">
tool_contents_tool_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
