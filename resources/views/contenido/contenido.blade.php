@extends('home')

@section('contenido')
				<template v-if="menu==0">
				    <dashboard></dashboard>
				</template>
				<template v-if="menu==1">
					<institucion></institucion>    
				</template>
				<template v-if="menu==2">
				    <usuario></usuario>
				</template>	
				<template v-if="menu==3">
				    <cuestionario></cuestionario>
				</template>				
@endsection