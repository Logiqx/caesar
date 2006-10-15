<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method="text"/>

<xsl:variable name='tab'><xsl:text>&#9;</xsl:text></xsl:variable>

<xsl:template match="library">
library<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@type"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="name"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="version"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="date"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="status"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="emulates"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="comment"/>
<xsl:for-each select="homepage">
library_homepage<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@status"/>
</xsl:for-each>
<xsl:for-each select="author_link">
library_author_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
<xsl:for-each select="emulator_links">
<xsl:for-each select="emulator_link">
library_emulator_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="tool_links">
<xsl:for-each select="tool_link">
library_tool_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="files">
<xsl:for-each select="file">
library_file<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@name"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="library_relatives">
<xsl:for-each select="library_predecessors">
<xsl:for-each select="library_link">
library_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>predecessor
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="library_descendants">
<xsl:for-each select="library_link">
library_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>successor
</xsl:for-each>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

<xsl:template match="library_contents">
library_contents<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="title"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="comment"/>
<xsl:for-each select="library_links">
<xsl:for-each select="library_link">
library_contents_library_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
