<?xml version = "1.0" encoding = "utf-8"?>
<definitions name="WSValidacion" targetNamespace="npi" xmlns:wsdlns="npi" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://schemas.xmlsoap.org/wsdl/" xmlns:tns="npi">
	<types>
		<schema targetNamespace="npi" xmlns="http://www.w3.org/2001/XMLSchema" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" elementFormDefault="qualified">
			<element name="WSValidacion.Execute">
				<complexType>
					<sequence>
						<element minOccurs="1" maxOccurs="1" name="Solicitud" type="xsd:string" />
					</sequence>
				</complexType>
			</element>
			<element name="WSValidacion.ExecuteResponse">
				<complexType>
					<sequence>
						<element minOccurs="1" maxOccurs="1" name="Respuesta" type="xsd:string" />
					</sequence>
				</complexType>
			</element>
		</schema>
	</types>
	<message name="WSValidacion.ExecuteSoapIn">
		<part name="parameters" element="tns:WSValidacion.Execute" />
	</message>
	<message name="WSValidacion.ExecuteSoapOut">
		<part name="parameters" element="tns:WSValidacion.ExecuteResponse" />
	</message>
	<portType name="WSValidacionSoapPort">
		<operation name="Execute">
			<input message="wsdlns:WSValidacion.ExecuteSoapIn" />
			<output message="wsdlns:WSValidacion.ExecuteSoapOut" />
		</operation>
	</portType>
	<binding name="WSValidacionSoapBinding" type="wsdlns:WSValidacionSoapPort">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
		<operation name="Execute">
			<soap:operation soapAction="npiaction/AWSVALIDACION.Execute" />
			<input>
				<soap:body use="literal" />
			</input>
			<output>
				<soap:body use="literal" />
			</output>
		</operation>
	</binding>
	<service name="WSValidacion">
		<port name="WSValidacionSoapPort" binding="wsdlns:WSValidacionSoapBinding">
			<soap:address location="http://npievo.admifarmgroup.com/awsvalidacion.aspx" />
		</port>
	</service>
</definitions>
