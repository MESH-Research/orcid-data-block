<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:internal="http://www.orcid.org/ns/internal"
                xmlns:funding="http://www.orcid.org/ns/funding"
                xmlns:preferences="http://www.orcid.org/ns/preferences"
                xmlns:address="http://www.orcid.org/ns/address"
                xmlns:education="http://www.orcid.org/ns/education"
                xmlns:work="http://www.orcid.org/ns/work"
                xmlns:deprecated="http://www.orcid.org/ns/deprecated"
                xmlns:other-name="http://www.orcid.org/ns/other-name"
                xmlns:history="http://www.orcid.org/ns/history"
                xmlns:employment="http://www.orcid.org/ns/employment"
                xmlns:error="http://www.orcid.org/ns/error"
                xmlns:common="http://www.orcid.org/ns/common"
                xmlns:person="http://www.orcid.org/ns/person"
                xmlns:activities="http://www.orcid.org/ns/activities"
                xmlns:record="http://www.orcid.org/ns/record"
                xmlns:researcher-url="http://www.orcid.org/ns/researcher-url"
                xmlns:peer-review="http://www.orcid.org/ns/peer-review"
                xmlns:personal-details="http://www.orcid.org/ns/personal-details"
                xmlns:bulk="http://www.orcid.org/ns/bulk"
                xmlns:keyword="http://www.orcid.org/ns/keyword"
                xmlns:email="http://www.orcid.org/ns/email"
                xmlns:external-identifier="http://www.orcid.org/ns/external-identifier"
                xmlns:distinction="http://www.orcid.org/ns/distinction"
                xmlns:membership="http://www.orcid.org/ns/membership"
                xmlns:invited-position="http://www.orcid.org/ns/invited-position"
                xmlns:qualification="http://www.orcid.org/ns/qualification"
                xmlns:service="http://www.orcid.org/ns/service"
                xmlns:research-resource="http://www.orcid.org/ns/research-resource" version="1.0">

    <!-- parameters -->
    <!-- NOTE: parameter values must be quoted if you want strings (and not XPath entries) -->
    <xsl:param name="display_header" select="'yes'"/>
    <xsl:param name="display_personal" select="'yes'"/>
    <xsl:param name="display_education" select="'yes'"/>
    <xsl:param name="display_employment" select="'yes'"/>
    <xsl:param name="display_works" select="'yes'"/>
    <!-- WP shortcode parameters that go with works section -->
    <xsl:param name="works_type" select="'all'"/>
    <xsl:param name="works_start_year" select="'1900'"/>
    <!-- -->
    <xsl:param name="display_fundings" select="'yes'"/>
    <xsl:param name="display_peer_reviews" select="'yes'"/>
    <xsl:param name="display_invited_positions" select="'yes'"/>
    <xsl:param name="display_memberships" select="'yes'"/>
    <xsl:param name="display_qualifications" select="'yes'"/>
    <xsl:param name="display_research_resources" select="'yes'"/>
    <xsl:param name="display_services" select="'yes'"/>

    <!-- output format -->
    <xsl:output omit-xml-declaration="yes" indent="yes"/>

    <xsl:template match="/">

        <article id="orcid_data">

            <!-- START: header-->
            <xsl:if test="$display_header='yes'">
                <h1>ORCID Profile</h1>
            </xsl:if>
            <!-- END: header-->

            <!-- START: personal -->
            <xsl:if test="$display_personal='yes'">
                <h2>Biographical Information</h2>

                <!-- name -->
                <section id="orcid_names">
                    <h3>Name Information</h3>

                    <xsl:if test="record:record/person:person/person:name/personal-details:credit-name">
                        <h4 style="margin-bottom:0">Published Name</h4>
                        <span><xsl:value-of select="record:record/person:person/person:name/personal-details:credit-name"/></span>
                    </xsl:if>

                    <h4 style="margin-bottom:0">Full Name</h4>
                    <span><xsl:value-of select="record:record/person:person/person:name/personal-details:given-names"/>
                    <xsl:text> </xsl:text>
                    <xsl:value-of select="record:record/person:person/person:name/personal-details:family-name"/></span>

                    <xsl:if test="record:record/person:person/other-name:other-names/other-name:other-name">
                        <h4 style="margin-bottom:0">Also Known As</h4>
                        <xsl:for-each select="record:record/person:person/other-name:other-names/other-name:other-name">

                            <span><xsl:value-of select="other-name:content"/></span> <br/>
                        </xsl:for-each>
                    </xsl:if>

                </section>

                <!-- biography -->
                <section id="orcid_biography">
                    <h3 style="margin-bottom:0">Biography</h3>
                    <xsl:choose>
                        <xsl:when test="record:record/person:person/person:biography">
                            <p><xsl:value-of select="record:record/person:person/person:biography/personal-details:content"/></p>
                        </xsl:when>
                        <xsl:otherwise><p>No biography entered.</p></xsl:otherwise>
                    </xsl:choose>
                </section>

                <!-- keywords -->
                <!--
                <div>Keywords</div>
                <div>
                    <table border="1">
                        <tr bgcolor="#9acd32">
                            <th>Keywords</th>
                        </tr>
                        <xsl:if test="record:record/person:person/keyword:keywords/keyword:keyword">
                            <xsl:for-each select="record:record/person:person/keyword:keywords/keyword:keyword">
                                <tr>
                                    <td>
                                        <xsl:value-of select="keyword:content"/>
                                    </td>
                                </tr>
                            </xsl:for-each>
                        </xsl:if>
                    </table>
                </div>
                -->

                <!-- websites -->
                <section id="orcid_urls">
                    <h3 style="margin-bottom:0">Websites</h3>
                    <xsl:if test="record:record/person:person/researcher-url:researcher-urls/researcher-url:researcher-url">
                        <ul style="list-style:none; padding-left:0;">
                            <xsl:for-each select="record:record/person:person/researcher-url:researcher-urls/researcher-url:researcher-url">
                                <li>
                                    <xsl:element name="a">
                                        <xsl:attribute name="href">
                                            <xsl:value-of select="researcher-url:url"/>
                                        </xsl:attribute>
                                        <xsl:value-of select="researcher-url:url-name"/>
                                    </xsl:element>
                                </li>
                            </xsl:for-each>
                        </ul>
                    </xsl:if>
                </section>

                <!--
                <div>Skipping Section: external-identifier:external-identifiers</div>
                <div>Skipping Section: address:addresses</div>
                -->

            </xsl:if>
            <!-- END: personal -->

            <!-- START: education -->
            <xsl:if test="$display_education='yes'">
                <section id="orcid_education">
                    <h2>Education</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:educations/activities:affiliation-group/education:education-summary">
                            <xsl:for-each
                                select="record:record/activities:activities-summary/activities:educations/activities:affiliation-group/education:education-summary">
                                <!-- sort with end AND start dates, in case there are records with the same end-date -->
                                <xsl:sort select="common:end-date/common:year" data-type="number" order="descending"/>
                                <xsl:sort select="common:start-date/common:year" data-type="number" order="descending"/>
                                <xsl:sort select="common:organization/common:name" data-type="text"/>

                                <h3 style="margin-bottom:0;"><xsl:value-of select="common:role-title"/></h3>
                                <span><xsl:value-of select="common:organization/common:name"/></span><br/>
                                <span><xsl:value-of select="common:end-date/common:year"/></span>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No education information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: education -->

            <!-- START: employment -->
            <xsl:if test="$display_employment='yes'">
                <section id="orcid_employment">
                    <h2>Employment</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:employments/activities:affiliation-group/employment:employment-summary">
                            <xsl:for-each
                                select="record:record/activities:activities-summary/activities:employments/activities:affiliation-group/employment:employment-summary">
                                <!-- sort with end  AND start dates, in case there are records with the same end-date -->
                                <xsl:sort select="common:end-date/common:year" data-type="number" order="descending"/>
                                <xsl:sort select="common:start-date/common:year" data-type="number" order="descending"/>
                                <xsl:sort select="common:organization/common:name" data-type="text"/>

                                <h3 style="margin-bottom:0;"><xsl:value-of select="common:organization/common:name"/></h3>
                                <span><xsl:value-of select="common:start-date/common:year"/> –
                                <xsl:choose>
                                    <xsl:when test="common:end-date/common:year">
                                        <xsl:value-of select="common:end-date/common:year"/>
                                    </xsl:when>
                                    <xsl:otherwise>Present</xsl:otherwise>
                                </xsl:choose>
                                </span>
                                <br/>
                                <span><xsl:value-of select="common:role-title"/> (<xsl:value-of select="common:department-name"/>)</span>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No employment information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: employmant -->

            <!-- START: works (activities-group) -->
            <xsl:if test="$display_works='yes'">
                <section id="orcid_work">
                    <h2>Works</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:works/activities:group">
                            <!-- if at least 1 "activities:works/activities:group" exists -->
                            <xsl:for-each select="record:record/activities:activities-summary/activities:works/activities:group">
                                <xsl:sort select="work:work-summary/common:publication-date/common:year" data-type="number" order="descending"/>
                                <xsl:sort select="work:work-summary/work:type" data-type="text"/>
                                <!-- -->
                                <!-- IF statement(s) here as a filter -->
                                <!-- work type -->
                                <xsl:if test="$works_type='all' or $works_type=work:work-summary/work:type">
                                    <!-- publication year-->
                                    <!-- there's no >= so we need to do > OR = in 2 parts -->
                                    <xsl:if test="work:work-summary/common:publication-date/common:year &gt; $works_start_year or work:work-summary/common:publication-date/common:year = $works_start_year">
                                        <h3 style="margin-bottom:0"><xsl:value-of select="work:work-summary/work:title/common:title"/></h3>
                                        <span><xsl:value-of select="work:work-summary/work:journal-title"/></span><br/>
                                        <span>Type: <xsl:value-of select="work:work-summary/work:type"/></span><br/>
                                        <span><xsl:value-of select="work:work-summary/common:publication-date/common:year"/></span>
                                        <!-- if at least 1 "common:external-ids/common:external-id" exists -->
                                        <xsl:if test="work:work-summary/common:external-ids/common:external-id">
                                            <ul style="list-style:none; padding-left:0; margin-top:0">
                                            <xsl:for-each select="work:work-summary/common:external-ids/common:external-id">
                                                <li>
                                                    <xsl:element name="a">
                                                        <xsl:attribute name="href">
                                                            <xsl:value-of select="common:external-id-url"/>
                                                        </xsl:attribute>
                                                        <xsl:value-of select="common:external-id-url"/>
                                                    </xsl:element>
                                                </li>
                                            </xsl:for-each>
                                            </ul>
                                        </xsl:if>
                                    </xsl:if>
                                </xsl:if>
                                <!-- end IF filters -->
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No works information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: works -->

            <!-- START: fundings -->
            <xsl:if test="$display_fundings='yes'">
                <section id="orcid_fundings">
                    <h2>Funding Sources</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:fundings/activities:group">
                            <xsl:for-each select="record:record/activities:activities-summary/activities:fundings/activities:group">
                                <h3 style="margin-bottom:0"><xsl:value-of select="funding:funding-summary/funding:title/common:title"/></h3>
                                <span><xsl:value-of select="funding:funding-summary/common:organization/common:name"/></span><br/>
                                <span>Type: <xsl:value-of select="funding:funding-summary/funding:type"/></span><br/>
                                <span><xsl:value-of select="funding:funding-summary/common:start-date/common:year"/> –
                                <xsl:choose>
                                    <xsl:when test="funding:funding-summary/common:end-date/common:year">
                                        <xsl:value-of select="funding:funding-summary/common:end-date/common:year"/>
                                    </xsl:when>
                                    <xsl:otherwise>Present</xsl:otherwise>
                                </xsl:choose>
                                </span>

                                <xsl:if test="work:work-summary/common:external-ids/common:external-id">
                                    <ul style="list-style:none; padding-left:0; margin-top:0">
                                        <xsl:for-each select="work:work-summary/common:external-ids/common:external-id">
                                            <li>
                                                <xsl:element name="a">
                                                    <xsl:attribute name="href">
                                                        <xsl:value-of select="common:external-id-url"/>
                                                    </xsl:attribute>
                                                    <xsl:value-of select="common:external-id-url"/>
                                                </xsl:element>
                                            </li>
                                        </xsl:for-each>
                                    </ul>
                                </xsl:if>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No funding information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: fundings -->

            <!-- START: peer-reviews -->
            <xsl:if test="$display_peer_reviews='yes'">
                <h3>
                    <div>Peer Reviews</div>
                </h3>
                <div>
                    <table border="1">
                        <tr bgcolor="#9acd32">
                            <th>Convening Organization Name</th>
                            <th>City</th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Completion Year</th>
                            <th>Completion Month</th>
                            <th>Completion Day</th>
                        </tr>
                        <xsl:if test="record:record/activities:activities-summary/activities:peer-reviews/activities:group/activities:peer-review-group">
                            <xsl:for-each
                                    select="record:record/activities:activities-summary/activities:peer-reviews/activities:group/activities:peer-review-group">
                                <tr>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:convening-organization/common:name"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:convening-organization/common:address/common:city"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:convening-organization/common:address/common:region"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:convening-organization/common:address/common:country"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:completion-date/common:year"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:completion-date/common:month"/>
                                    </td>
                                    <td>
                                        <xsl:value-of
                                                select="peer-review:peer-review-summary/peer-review:completion-date/common:day"/>
                                    </td>
                                </tr>
                            </xsl:for-each>
                        </xsl:if>
                    </table>
                </div>
            </xsl:if>
            <!-- END: peer-reviews -->

            <!-- START: invited_positions -->
            <xsl:if test="$display_invited_positions='yes'">
                <section>
                    <h2>Invited Positions</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:invited-positions/activities:affiliation-group">
                            <xsl:for-each select="record:record/activities:activities-summary/activities:invited-positions/activities:affiliation-group">
                                <h3 style="margin-bottom:0"><xsl:value-of select="invited-position:invited-position-summary/common:department-name"/></h3>
                                <span><xsl:value-of select="invited-position:invited-position-summary/common:organization/common:name"/></span><br/>
                                <xsl:element name="a">
                                    <xsl:attribute name="href">
                                        <xsl:value-of select="invited-position:invited-position-summary/common:url"/>
                                    </xsl:attribute>
                                    <xsl:value-of select="invited-position:invited-position-summary/common:url"/>
                                </xsl:element><br/>
                                <span><xsl:value-of select="invited-position:invited-position-summary/common:start-date/common:year"/></span>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No invited position information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: invited_positions -->

            <!-- START: memberships -->
            <xsl:if test="$display_memberships='yes'">
                <section id="orcid_memberships">
                    <h2>Memberships</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:memberships/activities:affiliation-group">
                        <xsl:for-each select="record:record/activities:activities-summary/activities:memberships/activities:affiliation-group">
                            <h3 style="margin-bottom:0"><xsl:value-of select="membership:membership-summary/common:department-name"/></h3>
                            <span><xsl:value-of select="membership:membership-summary/common:organization/common:name"/></span><br/>
                            <xsl:element name="a">
                                <xsl:attribute name="href">
                                    <xsl:value-of select="membership:membership-summary/common:url"/>
                                </xsl:attribute>
                                <xsl:value-of select="membership:membership-summary/common:url"/>
                            </xsl:element><br/>
                            <span><xsl:value-of select="membership:membership-summary/common:start-date/common:year"/></span><br/>
                        </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No membership information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: memberships -->

            <!-- START: qualifications -->
            <xsl:if test="$display_qualifications='yes'">
                <section id="orcid_qualifications">
                    <h2>Qualifications</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:qualifications/activities:affiliation-group">
                            <xsl:for-each select="record:record/activities:activities-summary/activities:qualifications/activities:affiliation-group">
                                <h3 style="margin-bottom:0"><xsl:value-of select="qualification:qualification-summary/common:department-name"/></h3>
                                <span><xsl:value-of select="qualification:qualification-summary/common:organization/common:name"/></span><br/>
                                <xsl:element name="a">
                                    <xsl:attribute name="href">
                                        <xsl:value-of select="qualification:qualification-summary/common:url"/>
                                    </xsl:attribute>
                                    <xsl:value-of select="qualification:qualification-summary/common:url"/>
                                </xsl:element><br/>
                                <span><xsl:value-of select="qualification:qualification-summary/common:start-date/common:year"/></span><br/>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No qualifications information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: qualificationss -->

            <!-- START: research_resources -->
            <!--
                we have an issue here: it's not clear if there can be MULTIPLE <activities:group>

                we do know that there can be MULTIPLE <research-resource:research-resource-summary> within any <activities:group>
            -->
            <xsl:if test="$display_research_resources='yes'">
                <h3>
                    <div>Research Resources</div>
                </h3>
                <div>
                    <table border="1">
                        <tr bgcolor="#9acd32">
                            <th>Title</th>
                            <!--
                            <th>Organization</th>
                            -->
                            <th>Start Year</th>
                            <th>End Year</th>
                            <th>URL</th>
                        </tr>
                        <!-- START LOOP on <activities:group> -->
                        <xsl:if test="record:record/activities:activities-summary/activities:research-resources/activities:group">
                            <xsl:for-each
                                    select="record:record/activities:activities-summary/activities:research-resources/activities:group">
                                <!-- <tr><td>INSIDE 1st FOR LOOP</td></tr> -->
                                <!-- START 2ND LOOP on <research-resource:research-resource-summary> -->
                                <xsl:if test="research-resource:research-resource-summary">
                                    <xsl:for-each select="research-resource:research-resource-summary">

                                        <!-- -->
                                        <tr>
                                            <td>
                                                <xsl:value-of
                                                        select="research-resource:proposal/research-resource:title/common:title"/>
                                            </td>
                                            <!-- the <research-resource:hosts> can contain multiple organizations -->
                                            <td>
                                                <xsl:if test="research-resource:proposal/research-resource:hosts/common:organization">
                                                    <xsl:for-each
                                                            select="research-resource:proposal/research-resource:hosts/common:organization">
                                                        <xsl:value-of select="common:name"/>
                                                        <br/>
                                                    </xsl:for-each>
                                                </xsl:if>
                                            </td>
                                            <td>
                                                <xsl:value-of
                                                        select="research-resource:proposal/common:start-date/common:year"/>
                                            </td>
                                            <td>
                                                <xsl:value-of
                                                        select="research-resource:proposal/common:end-date/common:year"/>
                                            </td>
                                            <td>
                                                <xsl:value-of select="research-resource:proposal/common:url"/>
                                            </td>
                                        </tr>

                                        <!-- -->
                                    </xsl:for-each>
                                </xsl:if>
                                <!-- END 2ND LOOP on <research-resource:research-resource-summary> -->
                            </xsl:for-each>
                        </xsl:if>
                        <!-- END LOOP on <activities:group> -->
                    </table>
                </div>
            </xsl:if>
            <!-- END: research_resources -->

            <!-- START: services -->
            <xsl:if test="$display_services='yes'">
                <section id="orcid_services">
                    <h2>Services</h2>
                    <xsl:choose>
                        <xsl:when test="record:record/activities:activities-summary/activities:services/activities:affiliation-group">
                            <xsl:for-each select="record:record/activities:activities-summary/activities:services/activities:affiliation-group">
                                <h3 style="margin-bottom:0"><xsl:value-of select="service:service-summary/common:department-name"/></h3>
                                <span><xsl:value-of select="service:service-summary/common:organization/common:name"/></span><br/>
                                <xsl:element name="a">
                                    <xsl:attribute name="href">
                                        <xsl:value-of select="service:service-summary/common:url"/>
                                    </xsl:attribute>
                                    <xsl:value-of select="service:service-summary/common:url"/>
                                </xsl:element><br/>
                                <span><xsl:value-of select="service:service-summary/common:start-date/common:year"/></span><br/>
                            </xsl:for-each>
                        </xsl:when>
                        <xsl:otherwise><span>No services information</span></xsl:otherwise>
                    </xsl:choose>
                </section>
            </xsl:if>
            <!-- END: services -->

        </article>

    </xsl:template>

</xsl:stylesheet>
