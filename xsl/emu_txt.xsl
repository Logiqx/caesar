<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method="text"/>

<xsl:variable name='tab'><xsl:text>&#9;</xsl:text></xsl:variable>

<xsl:template match="a">&lt;a href="<xsl:value-of select="."/>"&gt;<xsl:value-of select="."/>&lt;/a&gt;</xsl:template>
    
<xsl:template match="emulator">
emulator<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@type"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@dat"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@dat_type"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@aspectx"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@aspecty"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="name"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="version"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="date"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="platform"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="emulates"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="comment"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="status"/>
<xsl:for-each select="homepage">
emulator_homepage<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@status"/>
</xsl:for-each>
<xsl:for-each select="author_link">
emulator_author_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:copy-of select='$tab'/>author
</xsl:for-each>
<xsl:for-each select="cpu_links">
<xsl:for-each select="library_link">
emulator_library_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="tool_links">
<xsl:for-each select="tool_link">
emulator_tool_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="features">
emulator_features<xsl:copy-of select='$tab'/>
<xsl:value-of select="../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="sound/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="source/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="screendump/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="hiscoresave/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="savegame/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="recordinput/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="dips/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="cheat/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="autoframeskip/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="throttle/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="network/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="recordsound/."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="rotate/."/>
</xsl:for-each>
<xsl:for-each select="controllers">
<xsl:for-each select="controller">
emulator_controller<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="contributors">
<xsl:for-each select="contributor">
<xsl:for-each select="author_link">
emulator_author_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="../comment/."/><xsl:copy-of select='$tab'/>contributor
</xsl:for-each>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="relatives">
<xsl:for-each select="predecessors">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>predecessor
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="derivative_of">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>derivative_of
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="hybrid_of">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>hybrid_of
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="modification_of">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>modification_of
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="port_of">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>port_of
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="alt_versions">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>alt_version
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="ports">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>port
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="modified_versions">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>modified_version
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="derivatives">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>derivative
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="successors">
<xsl:for-each select="emulator_link">
emulator_relative_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>successor
</xsl:for-each>
</xsl:for-each>
</xsl:for-each>
<xsl:for-each select="files">
<xsl:for-each select="file">
emulator_file<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="."/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@name"/>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

<xsl:template match="emulator_contents">
emulator_contents<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="title"/><xsl:copy-of select='$tab'/>
<xsl:for-each select="comment"><xsl:apply-templates/></xsl:for-each>
<xsl:for-each select="emulator_links">
<xsl:for-each select="emulator_link">
emulator_contents_emulator_link<xsl:copy-of select='$tab'/>
<xsl:value-of select="../../@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/>
</xsl:for-each>
<xsl:for-each select="old_name">
<xsl:for-each select="emulator_link">
emulator_old_name<xsl:copy-of select='$tab'/>
<xsl:value-of select="@id"/><xsl:copy-of select='$tab'/>
<xsl:value-of select="../name"/>
</xsl:for-each>
</xsl:for-each>
</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
